<?php

namespace Favicode\Sample01\Block;

class DisplayHelloWorld extends \Magento\Framework\View\Element\Template
{
    public $_scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $data); // Call parent constructor
    }
    /**
     * @return string
     */
    public function displayHelloWorld()
    {
        return "Display Hello World: ". $this->_scopeConfig->getValue(
            'helloworld/hello_group/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
