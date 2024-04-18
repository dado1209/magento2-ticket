<?php

namespace Favicode\ObserverTest\Observer;

use Magento\Framework\Event\Observer;

use Magento\Framework\Event\ObserverInterface;
class Observer1 implements  ObserverInterface
{

    public function execute(Observer $observer)
    {
        echo 'Observer1 was notified of event', '<br>';
        $myEventData = $observer->getData('myEventData');
        echo 'Observer1 got value: ', $myEventData , '<br>';
    }
}
