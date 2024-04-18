<?php

namespace Favicode\Tickets\Model\ResourceModel\TicketReply;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize ticket reply Collection
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            \Favicode\Tickets\Model\TicketReply::class,
            \Favicode\Tickets\Model\ResourceModel\TicketReply::class
        );
    }
}
