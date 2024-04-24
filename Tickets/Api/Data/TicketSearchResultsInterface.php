<?php

namespace Favicode\Tickets\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TicketSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get ticket list.
     *
     * @return TicketInterface[]
     */
    public function getList();

    /**
     * Set ticket list.
     *
     * @param TicketInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
