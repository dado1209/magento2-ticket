<?php

namespace Favicode\Sample02\Controller\Test;

class B extends \Magento\Framework\App\Action\Action
{
    protected $bFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Favicode\Sample02\Model\BFactory $bFactory
    ) {
        parent::__construct($context);
        $this->bFactory = $bFactory;
    }

    public function execute()
    {
        $b = $this->bFactory->create();
        var_dump($b);
    }
}
