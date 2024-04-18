<?php

namespace Favicode\Sample06\Controller\Adminhtml\News;

use Magento\Framework\Controller\ResultFactory;
use \Magento\Backend\App\Action\Context;

class Create extends \Magento\Backend\App\Action
{
    private $newsModelFactory;
    private $newsRepository;


    public function __construct(Context $context,
                                \Favicode\Sample04\Api\NewsRepositoryInterface $newsRepository,
                                \Favicode\Sample04\Api\Data\NewsInterfaceFactory $newsModelFactory)
    {
        $this->newsRepository = $newsRepository;
        $this->newsModelFactory = $newsModelFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $newsTitle = $this->_request->getParam('title');
        $news = $this->newsModelFactory->create();
        $news->setTitle($newsTitle);
        $this->newsRepository->save($news);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}
