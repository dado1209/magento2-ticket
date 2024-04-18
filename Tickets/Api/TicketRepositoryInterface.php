<?php

namespace Favicode\Tickets\Api;

interface TicketRepositoryInterface
{
    public function getById($ticketId, $websiteId);

    public function getList($userId, $websiteId);

    public function save($ticket);
}
