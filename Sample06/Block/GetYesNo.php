<?php

namespace Favicode\Sample06\Block;

class GetYesNo extends \Magento\Framework\View\Element\Template
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
    public function getYesNoValue()
    {
        return $this->_scopeConfig->getValue(
            'yesno/yesno_group/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
