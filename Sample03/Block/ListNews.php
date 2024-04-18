<?php

namespace Favicode\Sample03\Block;

class ListNews extends \Magento\Framework\View\Element\Template
{

    public $newsCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Favicode\Sample03\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory,
    ) {
        $this->newsCollectionFactory = $newsCollectionFactory;
        parent::__construct($context);
    }
    public function getTop10News()
    {
        $newsList = $this->newsCollectionFactory->create()->addOrder("created_at", "DESC")->setPageSize(10);
        return $newsList;

    }
}
