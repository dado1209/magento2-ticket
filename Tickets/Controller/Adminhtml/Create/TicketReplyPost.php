<?php

namespace Favicode\Tickets\Controller\Adminhtml\Create;


use _PHPStan_5473b6701\Nette\Schema\ValidationException;
use Exception;
use Favicode\Tickets\Api\TicketReplyRepositoryInterface;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Favicode\Tickets\Model\TicketReplyFactory;
use Magento\Backend\Model\Auth\Session;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\InputException;
use Magento\Store\Model\StoreManagerInterface;

class TicketReplyPost extends Action
{
    private Validator $formKeyValidator;
    private TicketReplyFactory $ticketReplyModelFactory;
    private StoreManagerInterface $storeManager;

    private TicketRepositoryInterface $ticketRepository;
    private Session $authSession;
    private UrlInterface $backendUrl;

    /**
     * @var TicketReplyRepositoryInterface
     */
    private TicketReplyRepositoryInterface $ticketReplyRepository;

    /**
     * TicketReplyPost constructor.
     * @param Context $context
     * @param Validator $formKeyValidator
     * @param StoreManagerInterface $storeManager
     * @param TicketReplyFactory $ticketReplyModelFactory
     * @param TicketRepositoryInterface $ticketRepository
     * @param Session $authSession
     * @param UrlInterface $backendUrl
     * @param TicketReplyRepositoryInterface $ticketReplyRepository
     */
    public function __construct(
        Context                        $context,
        Validator                      $formKeyValidator,
        StoreManagerInterface          $storeManager,
        TicketReplyFactory             $ticketReplyModelFactory,
        TicketRepositoryInterface      $ticketRepository,
        Session                        $authSession,
        UrlInterface                   $backendUrl,
        TicketReplyRepositoryInterface $ticketReplyRepository,
    )
    {
        $this->formKeyValidator = $formKeyValidator;
        $this->storeManager = $storeManager;
        $this->ticketReplyModelFactory = $ticketReplyModelFactory;
        $this->ticketRepository = $ticketRepository;
        $this->authSession = $authSession;
        $this->backendUrl = $backendUrl;
        $this->ticketReplyRepository = $ticketReplyRepository;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->backendUrl->getUrl('tickets/view/history'));
        try {
            $postValues = $this->getTicketReplyPostValues();
            //check if ticket id is valid
            //todo: find something better than is_numeric. it returns true for floats
            if (!is_numeric($postValues['ticket_id'])) {
                $this->messageManager->addErrorMessage(__('Invalid ticket id'));
                return $redirect;
            }
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $userId = $this->authSession->getUser()->getId();
            $ticketId = $postValues['ticket_id'];
            $ticket = $this->ticketRepository->getById($ticketId, $websiteId);
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
            $ticketReply->setIsUserAdmin(true);
            $this->ticketReplyRepository->save($ticketReply);
        } catch (ValidationException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
            return $redirect;
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
            return $redirect;
        } catch (Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong'));
            return $redirect;
        }
        $this->messageManager->addSuccessMessage(__('Your reply has been created'));
        return $redirect;
    }

    /**
     * @throws InputException | ValidationException
     */
    protected function getTicketReplyPostValues()
    {
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
