<?php

namespace Favicode\Tickets\Controller\View;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class History extends Action
{
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;
    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * History constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Session $customerSession
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        Session     $customerSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return Page | Redirect
     */
    public function execute(): Page|Redirect
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('/customer/account/login');
        if (!$this->customerSession->isLoggedIn()) {
            return $redirect;
        }
        return $this->resultPageFactory->create();
    }
}
