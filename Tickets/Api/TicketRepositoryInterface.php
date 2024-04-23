<?php

namespace Favicode\Tickets\Api;

use Favicode\Tickets\Api\Data\TicketInterface;
use Magento\Framework\DataObject;

interface TicketRepositoryInterface
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
    public function getById(int $ticketId, int $websiteId): TicketInterface;

    /**
     * get ticket list Api data.
     * @param int $userId
     * @param int $websiteId
     * @return array
     *
     * @api
     */
    public function getList(int $userId, int $websiteId): array;

    /**
     * save ticket Api.
     *
     * @param TicketInterface $ticket
     * @return void
     * @api
     */
    public function save(TicketInterface $ticket): void;
}
