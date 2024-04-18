<?php

namespace Favicode\Sample04\Block;

use PHPUnit\Exception;

class ListNews extends \Magento\Framework\View\Element\Template
{

    private $newsCollectionFactory;
    private $searcnCriteriaBuilder;
    private $newsRepository;
    private $sortOrderBuilder;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Favicode\Sample03\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Favicode\Sample04\Api\NewsRepositoryInterface $newsRepository,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
    ) {
        $this->newsCollectionFactory = $newsCollectionFactory;
        $this->searcnCriteriaBuilder = $searchCriteriaBuilder;
        $this->newsRepository = $newsRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        parent::__construct($context);
    }
    public function getLast10News()
    {
        try {
            $sortOrder = $this->sortOrderBuilder->setField('created_at')->setDirection('DESC')->create();
            $searchCriteria = $this->searcnCriteriaBuilder->setSortOrders([$sortOrder])->setPageSize(10)->create();
            $newsList = $this->newsRepository->getList($searchCriteria)->getItems();
            //$newsList = $this->newsCollectionFactory->create()->addOrder("created_at", "DESC")->setPageSize(10);
            return $newsList;
        }
        catch (Exception $e) {
           var_dump($e);
           exit();
        }


    }
}
