<?php

namespace Favicode\Sample03\Block;

class ViewNews extends \Magento\Framework\View\Element\Template
{
    private $request;

    private $newsFactory;
    private $newsResourceFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Favicode\Sample03\Model\NewsFactory $newsFactory,
        \Magento\Framework\App\Request\Http $request,
        \Favicode\Sample03\Model\ResourceModel\News $newsResourceFactory,
    ) {
        $this->newsFactory = $newsFactory;
        $this->request = $request;
        $this->newsResourceFactory = $newsResourceFactory;
        parent::__construct($context);
    }
    public function getNewsById()
    {
        $newsId = $this->request->getParam("id");
        //load function is deprecated
        //return $this->newsFactory->create()->load($newsId);
        $news = $this->newsFactory->create();
        $this->newsResourceFactory->load($news, $newsId);
        return $news;
    }
}
