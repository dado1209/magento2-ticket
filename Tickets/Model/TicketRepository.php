<?php

namespace Favicode\Tickets\Model;

use Exception;
use Favicode\Tickets\Api\Data\TicketInterface;
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

    public function getById($ticketId, $websiteId): TicketInterface

    {
        $ticket = $this->ticketCollectionFactory->create()
            ->addFieldToFilter('website_id', $websiteId)
            ->addFieldToFilter('ticket_id', $ticketId)
            ->getFirstItem();
        return $ticket;

    }

    public function getList(int $userId, int $websiteId): array
    {
        $collection = $this->ticketCollectionFactory->create()
            ->addFieldToFilter('website_id', $websiteId);
        if($userId){
            $collection->addFieldToFilter('user_id', $userId);
        }
        return $collection->getItems();
    }

    public function save(TicketInterface $ticket): void
    {
        try {
            $this->ticketResource->save($ticket);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
    }

}

