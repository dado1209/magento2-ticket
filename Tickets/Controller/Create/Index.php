<?php

namespace Favicode\Tickets\Controller\Create;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
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
     * Index constructor.
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
