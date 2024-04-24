<?php

namespace Favicode\Tickets\Api;

use Favicode\Tickets\Api\Data\TicketInterface;
use Favicode\Tickets\Api\Data\TicketSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

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
    public function getById(int $ticketId, int $websiteId): TicketInterface;

    /**
     * get create ticket Api .
     *
     * @param int $websiteId
     *
     * @return TicketInterface
     * @api
     *
     */
    public function create(int $websiteId): TicketInterface;

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
    public function update(int $ticketId, int $websiteId): TicketInterface;

    /**
     * get ticket Api data.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @api
     *
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete ticket
     *
     * @param TicketInterface $ticket
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     * @api
     */
    public function delete(TicketInterface $ticket);

    /**
     * @param string $ticketId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @api
     */
    public function deleteById($ticketId);

}
