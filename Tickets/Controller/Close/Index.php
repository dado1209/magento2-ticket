<?php

namespace Favicode\Tickets\Controller\Close;

use Exception;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Action
{
    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    /**
     * @var TicketRepositoryInterface
     */
    private TicketRepositoryInterface $ticketRepository;


    /**
     * Index constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     * @param TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        Context                   $context,
        Session                   $customerSession,
        StoreManagerInterface     $storeManager,
        TicketRepositoryInterface $ticketRepository,
    )
    {
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->ticketRepository = $ticketRepository;
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
            $ticketId = $this->getRequest()->getParam('ticket_id');
            //check if valid ticket id
            //todo: find something better than is_numric. it returns true for floats
            if (!is_numeric($ticketId)) {
                $this->messageManager->addErrorMessage(__('Invalid ticket id'));
                return $redirect;
            }
            //check if user has permission to close ticket
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $userId = $this->customerSession->getCustomerId();
            $ticket = $this->ticketRepository->getById($ticketId, $websiteId);
            if ($userId != $ticket->getUserId()) {
                $this->messageManager->addErrorMessage(__('You do not have permission to close this ticket'));
                return $redirect;
            }
            //check if ticket is already closed
            if (!$ticket->getIsOpen()) {
                $this->messageManager->addErrorMessage(__('This ticket has already been closed'));
                return $redirect;
            }
            $ticket->setIsOpen(false);
            $this->ticketRepository->save($ticket);

        } catch (Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong'));
            return $redirect;
        }
        $this->messageManager->addSuccessMessage(__('This ticket has been closed'));
        return $redirect;
    }
}
