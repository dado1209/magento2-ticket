<?php

namespace Favicode\Tickets\Controller\Create;


use _PHPStan_5473b6701\Nette\Schema\ValidationException;
use Exception;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Favicode\Tickets\Model\TicketFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\InputException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;



class TicketPost extends Action
{
    /**
     * @var Validator
     */
    private Validator $formKeyValidator;

    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var TicketFactory
     */
    private TicketFactory $ticketModelFactory;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    /**
     * @var TicketRepositoryInterface
     */
    private TicketRepositoryInterface $ticketRepository;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $orderCollectionFactory;



    /**
     * TicketPost constructor.
     * @param Context $context
     * @param Validator $formKeyValidator
     * @param Session $customerSession
     * @param TicketFactory $ticketModelFactory
     * @param StoreManagerInterface $storeManager
     * @param TicketRepositoryInterface $ticketRepository
     * @param CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        Context                   $context,
        Validator                 $formKeyValidator,
        Session                   $customerSession,
        TicketFactory             $ticketModelFactory,
        StoreManagerInterface     $storeManager,
        TicketRepositoryInterface $ticketRepository,
        CollectionFactory         $orderCollectionFactory,
    )
    {
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->ticketModelFactory = $ticketModelFactory;
        $this->storeManager = $storeManager;
        $this->ticketRepository = $ticketRepository;
        $this->orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('/customer/account/login');
        if (!$this->customerSession->isLoggedIn()) {
            return $redirect;
        }
        $redirect->setUrl('/tickets/view/history');
        try {
            $postValues = $this->getTicketPostValues();
            //check if order id is valid
            //todo: find something better than is_numeric. it returns true for floats
            $orderId = $postValues['order_id'];
            if (!is_numeric($orderId)) {
                $this->messageManager->addErrorMessage(__('Invalid order id'));
                return $redirect;
            }
            //check if user has permission to open ticket for order with orderId
            $customerId = $this->customerSession->getCustomerId();
            if (!$this->isCustomerCreatorOfOrder($customerId, $orderId)) {
                $this->messageManager->addErrorMessage(__('You are not allowed to make a ticket for this order'));
                return $redirect;
            }
            //create ticket
            $ticket = $this->ticketModelFactory->create();
            $ticket->setTitle($postValues['title']);
            $ticket->setSummary($postValues['summary']);
            $ticket->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
            $ticket->setUserId($customerId);
            $ticket->setOrderId($orderId);
            $this->ticketRepository->save($ticket);
        }
        catch (ValidationException $e){
            $this->messageManager->addErrorMessage(__($e->getMessage()));
            return $redirect;
        }
        catch (InputException $e){
            $this->messageManager->addErrorMessage(__($e->getMessage()));
            return $redirect;
        }
        catch (Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong'));
            return $redirect;
        }
        $this->messageManager->addSuccessMessage('Your ticket has been created');
        return $redirect;
    }

    /**
     * @param string $customerId
     * @param string $orderId
     * @return bool
     */
    protected function isCustomerCreatorOfOrder(string $customerId, string $orderId): bool
    {
        $customerOrders = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_id', [
                'eq' => $customerId
            ])->getItems();
        $customerOrderIds = [];
        foreach ($customerOrders as $order) {
            array_push($customerOrderIds, $order->getIncrementId());
        }

        if (!in_array($orderId, $customerOrderIds)) {
            return false;
        }
        return true;
    }

    /**
     * @throws InputException | ValidationException
     */
    protected function getTicketPostValues(){
        //throw error if invalid form key or invalid request
        if (!$this->formKeyValidator->validate($this->getRequest()) || !$this->getRequest()->isPost()) {
            throw new ValidationException(__('Invalid request'));
        }
        //validate post values
        $postValues = $this->getRequest()->getPost();
        if (empty($postValues['summary']) || empty($postValues['title'])) {
            throw new InputException(__('Title and Summary are required'));
        }
        return $postValues;
    }

}
