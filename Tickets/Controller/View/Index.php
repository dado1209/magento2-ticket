<?php

namespace Favicode\Tickets\Controller\View;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action
{
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $eventManager;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Context          $context,
        PageFactory      $resultPageFactory,
        ManagerInterface $eventManager
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    /**
     * @return Page|Redirect
     */
    public function execute(): Page|Redirect
    {
        $this->eventManager->dispatch('check_login');
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('/tickets/view/history');
        try {
            $orderId = $this->getRequest()->getParam('ticket_id');
            //check if valid ticket id
            //todo: find something better than is_numric. it returns true for floats
            if (!is_numeric($orderId)) {
                $this->messageManager->addErrorMessage(__('Invalid ticket id'));
                return $redirect;
            }
        } catch (Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong'));
            return $redirect;
        }
        return $this->resultPageFactory->create();
    }
}
