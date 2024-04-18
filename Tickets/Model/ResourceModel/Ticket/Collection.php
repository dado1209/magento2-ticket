<?php

namespace Favicode\Tickets\Model\ResourceModel\Ticket;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize ticket Collection
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            \Favicode\Tickets\Model\Ticket::class,
            \Favicode\Tickets\Model\ResourceModel\Ticket::class
        );
    }
}
