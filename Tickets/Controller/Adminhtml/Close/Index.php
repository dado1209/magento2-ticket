<?php

namespace Favicode\Tickets\Controller\Adminhtml\Close;

use Exception;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Action
{
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    /**
     * @var TicketRepositoryInterface
     */
    private TicketRepositoryInterface $ticketRepository;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $eventManager;
    /**
     * @var UrlInterface
     */
    private UrlInterface $backendUrl;

    /**
     * Index constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param TicketRepositoryInterface $ticketRepository
     * @param ManagerInterface $eventManager
     * @param UrlInterface $backendUrl
     */
    public function __construct(
        Context                   $context,
        StoreManagerInterface     $storeManager,
        TicketRepositoryInterface $ticketRepository,
        ManagerInterface          $eventManager,
        UrlInterface              $backendUrl,
    )
    {
        $this->storeManager = $storeManager;
        $this->ticketRepository = $ticketRepository;
        $this->eventManager = $eventManager;
        $this->backendUrl = $backendUrl;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $this->eventManager->dispatch('check_login');
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->backendUrl->getUrl('tickets/view/history'));
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
            $ticket = $this->ticketRepository->getById($ticketId, $websiteId);
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
