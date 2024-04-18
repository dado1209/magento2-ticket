<?php

namespace Favicode\Sample03\Model\ResourceModel\Comment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize news Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Favicode\Sample03\Model\Comment::class,
            \Favicode\Sample03\Model\ResourceModel\Comment::class
        );
    }
}
