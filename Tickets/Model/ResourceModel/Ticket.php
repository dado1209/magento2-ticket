<?php

namespace Favicode\Tickets\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Ticket extends AbstractDb
{
    /**
     * Initialize ticket Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('favicode_tickets', 'ticket_id');
    }
}
