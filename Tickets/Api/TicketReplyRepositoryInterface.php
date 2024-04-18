<?php

namespace Favicode\Tickets\Api;

interface TicketReplyRepositoryInterface
{
    public function getList($ticketId, $websiteId);

    public function save($ticketReply);

}
