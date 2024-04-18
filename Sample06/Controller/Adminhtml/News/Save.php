<?php

namespace Favicode\Sample06\Controller\Adminhtml\News;

use Magento\Framework\Controller\ResultFactory;
use \Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
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
        //how to handle this logic?
        //option 1: move to block/save.php. return save layout->save block->redirect to index
        //option 2: call block/save.php directly in controller and redirect to index
        //option 3: keep block logic inside controller
        $newsTitle = $this->_request->getParam('title');
        $news = $this->newsRepository->getById($this->_request->getParam('news_id'));
        $news->setTitle($newsTitle);
        $this->newsRepository->save($news);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}
