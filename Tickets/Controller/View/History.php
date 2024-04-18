<?php

namespace Favicode\Tickets\Controller\View;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class History extends Action
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
     * History constructor.
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
     * @return Page
     */
    public function execute(): Page
    {
        $this->eventManager->dispatch('check_login');
        return $this->resultPageFactory->create();
    }
}
