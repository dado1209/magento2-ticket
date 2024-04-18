<?php

namespace Favicode\Sample03\Controller\Test;

use Magento\Framework\App\Action\Context;

class Collection  extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Favicode\Sample03\Model\ResourceModel\News\Collection
     */
    protected $newsCollectionFactory;
    private $resultPageFactory;


    /**
     * Controller constructor.
     * @param Context $context
     * @param \Favicode\Sample03\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory
     */
    public function __construct(
        Context $context,
        \Favicode\Sample03\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory,
    ) {
        parent::__construct($context);

        $this->newsCollectionFactory = $newsCollectionFactory;
    }

    /**
     * Controller action.
     */
    public function execute()
    {

        $newsCollection = $this->newsCollectionFactory->create();

        $newsCollection->addFieldToFilter('news_id', ['gt' => 5]);

        foreach($newsCollection as $news) {
            var_dump(get_class($news));
            var_dump($news->debug());
        }

    }

}
