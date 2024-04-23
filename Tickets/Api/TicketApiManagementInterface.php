<?php

namespace Favicode\Tickets\Api;

use Favicode\Tickets\Api\Data\TicketInterface;

interface TicketApiManagementInterface
{
    /**
     * get ticket Api data.
     *
     * @param int $ticketId
     * @param int $websiteId
     *
     * @return TicketInterface
     * @api
     *
     */
    public function getTicketById(int $ticketId, int $websiteId): TicketInterface;

    /**
     * get create ticket Api .
     *
     * @param int $websiteId
     *
     * @return array
     * @api
     *
     */
    public function createTicket(int $websiteId): array;

    /**
     * update ticket Api data.
     *
     * @param int $ticketId
     * @param int $websiteId
     *
     * @return TicketInterface
     * @api
     *
     */
    public function updateTicketById(int $ticketId, int $websiteId): TicketInterface;

    /**
     * get ticket Api data.
     *
     * @param int $websiteId
     *
     * @return array
     * @api
     *
     */
    public function getTickets(int $websiteId): array;
}
