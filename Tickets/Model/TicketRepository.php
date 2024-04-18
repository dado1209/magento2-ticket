<?php

namespace Favicode\Tickets\Model;

use Exception;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Favicode\Tickets\Model\ResourceModel\Ticket\CollectionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;

class TicketRepository implements TicketRepositoryInterface
{

    private ResourceModel\Ticket $ticketResource;

    private CollectionFactory $ticketCollectionFactory;

    public function __construct(
        \Favicode\Tickets\Model\ResourceModel\Ticket $ticketResource,
        CollectionFactory                            $ticketCollectionFactory,
    )
    {
        $this->ticketResource = $ticketResource;
        $this->ticketCollectionFactory = $ticketCollectionFactory;
    }

    public function getById($ticketId, $websiteId): DataObject
    {
        return $this->ticketCollectionFactory->create()
            ->addFieldToFilter('website_id', $websiteId)
            ->addFieldToFilter('ticket_id', $ticketId)
            ->getFirstItem();
    }

    public function getList($userId, $websiteId): array
    {
        return $this->ticketCollectionFactory->create()
            ->addFieldToFilter('website_id', $websiteId)
            ->addFieldToFilter('user_id', $userId)
            ->getItems();
    }

    public function save($ticket): void
    {
        try {
            $this->ticketResource->save($ticket);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
    }
}

