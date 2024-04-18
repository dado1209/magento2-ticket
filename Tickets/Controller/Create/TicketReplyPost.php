<?php

namespace Favicode\Tickets\Controller\Create;


use _PHPStan_5473b6701\Nette\Schema\ValidationException;
use Exception;
use Favicode\Tickets\Api\TicketReplyRepositoryInterface;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Favicode\Tickets\Model\TicketReplyFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\InputException;
use Magento\Store\Model\StoreManagerInterface;

class TicketReplyPost extends Action
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
     * @var TicketReplyFactory
     */
    private TicketReplyFactory $ticketReplyModelFactory;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    /**
     * @var TicketReplyRepositoryInterface
     */
    private TicketReplyRepositoryInterface $ticketReplyRepository;
    /**
     * @var TicketRepositoryInterface
     */
    private TicketRepositoryInterface $ticketRepository;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $eventManager;

    /**
     * TicketReplyPost constructor.
     * @param Context $context
     * @param Validator $formKeyValidator
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     * @param TicketReplyFactory $ticketReplyModelFactory
     * @param TicketReplyRepositoryInterface $ticketReplyRepository
     * @param TicketRepositoryInterface $ticketRepository
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Context                        $context,
        Validator                      $formKeyValidator,
        Session                        $customerSession,
        StoreManagerInterface          $storeManager,
        TicketReplyFactory             $ticketReplyModelFactory,
        TicketReplyRepositoryInterface $ticketReplyRepository,
        TicketRepositoryInterface      $ticketRepository,
        ManagerInterface               $eventManager
    )
    {
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->ticketReplyRepository = $ticketReplyRepository;
        $this->ticketReplyModelFactory = $ticketReplyModelFactory;
        $this->ticketRepository = $ticketRepository;
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $this->eventManager->dispatch('check_login');
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('/tickets/view/history');
        try {
            $postValues = $this->getTicketReplyPostValues();
            //check if ticket id is valid
            //todo: find something better than is_numeric. it returns true for floats
            if (!is_numeric($postValues['ticket_id'])) {
                $this->messageManager->addErrorMessage(__('Invalid ticket id'));
                return $redirect;
            }
            //check if user has permission to reply to ticket
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $userId = $this->customerSession->getCustomerId();
            $ticketId = $postValues['ticket_id'];
            $ticket = $this->ticketRepository->getById($ticketId, $websiteId);
            if ($userId != $ticket->getUserId()) {
                $this->messageManager->addErrorMessage(__('You are not allowed to reply to this ticket'));
                return $redirect;
            }
            //check if ticket is open
            if (!$ticket->getIsOpen()) {
                $this->messageManager->addErrorMessage(__('You are no longer allowed to reply to this ticket'));
                return $redirect;
            }

            //create ticket reply
            $ticketReply = $this->ticketReplyModelFactory->create();
            $ticketReply->setSummary($postValues['summary']);
            $ticketReply->setWebsiteId($websiteId);
            $ticketReply->setUserId($userId);
            $ticketReply->setTicketId($ticketId);
            $this->ticketReplyRepository->save($ticketReply);
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
        $this->messageManager->addSuccessMessage(__('Your reply has been created'));
        return $redirect;
    }
    /**
     * @throws InputException | ValidationException
     */
    protected function getTicketReplyPostValues(){
        //throw error if invalid form key or invalid request
        if (!$this->formKeyValidator->validate($this->getRequest()) || !$this->getRequest()->isPost()) {
            throw new ValidationException(__('Invalid request'));
        }
        //validate post values
        $postValues = $this->getRequest()->getPost();
        if (empty($postValues['summary'])) {
            throw new InputException(__('Summary is required'));
        }
        return $postValues;
    }

}
