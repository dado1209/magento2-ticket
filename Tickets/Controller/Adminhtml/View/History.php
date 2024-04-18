<?php

namespace Favicode\Tickets\Controller\Adminhtml\View;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;

class History extends Action
{
    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Favicode_Tickets::tickets');
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Favicode_Ticket::tickets');
        $resultPage->getConfig()->getTitle()->prepend(__('Tickets'));

        return $resultPage;
    }

}
