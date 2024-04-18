<?php

namespace Favicode\Sample05\Block;

use Magento\Framework\View\Element\Template;


class Hello extends \Magento\Framework\View\Element\Template
{
    private $escaper;
    public function __construct(Template\Context $context, \Magento\Framework\Escaper $escaper, array $data = [])
    {
        parent::__construct($context, $data);
        $this->escaper = $escaper;
    }

    /**
     * @return string
     */
    public function getHelloWorld()
    {
        return 'Hello World :]';
    }
    //override deprecated escapeHtml function
    public function escapeHtml($data, $allowedTags = null): array | string
    {
        return $this->escaper->escapeHtml($data, $allowedTags);
    }
}
