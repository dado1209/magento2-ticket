<?php

namespace Favicode\ObserverTest\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action


{
    private $eventManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Event\ManagerInterface $eventManager
    ) {
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    public function execute()
    {
        echo 123, '<br>';
        $eventData = 69696;

        echo 'dispatching event before', '<br>';

        $this->eventManager->dispatch('my_module_event_before');

        echo 'dispatching event after', '<br>';

        $this->eventManager->dispatch('my_module_event_after', ['myEventData' => $eventData]);
    }
}
