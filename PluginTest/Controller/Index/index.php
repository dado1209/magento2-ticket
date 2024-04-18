<?php

namespace Favicode\PluginTest\Controller\Index;

class index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $value = 69;
        $squareValue = $this->square($value);
        echo 'executing plugin index. The square is: ' . $squareValue, '<br>';
        return $squareValue;
    }

    public function square($number)
    {
        return $number**2;
    }
}
