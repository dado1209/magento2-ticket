<?php

namespace Favicode\PluginTest\Plugin;

class indexPlugin
{
    public function beforeSquare($number){
        echo 'plugin is executing before square function in index', '<br>';
        return 2;
    }

    public function afterExecute(\Favicode\PluginTest\Controller\Index\Index $subject, $result)
    {
        echo 'plugin is executing after the execute function with result:', $result, '<br>';
        return $result;
    }

    public function aroundExecute(\Favicode\PluginTest\Controller\Index\Index $subject, callable $proceed)
    {
        echo 'bing' , '<br>';
        $result = $proceed();
        echo 'around result: ', $result, '<br>';
    }
}
