<?php

namespace Favicode\ObserverTest\Observer;

use Magento\Framework\Event\Observer;

use Magento\Framework\Event\ObserverInterface;
class Observer2 implements  ObserverInterface
{

    public function execute(Observer $observer)
    {
        echo 'Observer2 was notified of event', '<br>';

    }
}
