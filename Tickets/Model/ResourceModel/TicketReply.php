<?php

namespace Favicode\Tickets\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TicketReply extends AbstractDb
{
    /**
     * Initialize ticket reply Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('favicode_ticket_replies', 'ticket_reply_id');
    }
}
