<?php

namespace Favicode\Sample04\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Exception;

class ViewNews extends \Magento\Framework\View\Element\Template
{
    private $request;
    private $newsRepository;
    private $newsModelFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Favicode\Sample04\Api\NewsRepositoryInterface $newsRepository,
        \Favicode\Sample04\Api\Data\NewsInterfaceFactory $newsModelFactory
    ) {
        $this->request = $request;
        $this->newsRepository = $newsRepository;
        $this->newsModelFactory = $newsModelFactory;
        parent::__construct($context);
    }
    public function getNewsById()
    {
        try {
            $newsId = $this->request->getParam("id");
            return $this->newsRepository->getById($newsId);
        }
        catch (NoSuchEntityException $e){
            //return empty news to view if news could not be found
            return $this->newsModelFactory->create();
        }
        catch (Exception $e) {
            var_dump($e);
            exit();
        }
    }
}
