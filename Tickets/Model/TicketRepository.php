<?php

namespace Favicode\Tickets\Model;

use Exception;
use Favicode\Tickets\Api\Data\TicketInterface;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Favicode\Tickets\Model\ResourceModel\Ticket\CollectionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

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
            ->addFieldToFilter('ticket_id', $ticketId);
        if ($websiteId) {
            $ticket->addFieldToFilter('website_id', $websiteId);
        }
        if (!sizeof($ticket)) {
            throw new NoSuchEntityException(
                __("The ticket that was requested doesn't exist.")
            );
        };
        return $ticket->getFirstItem();

    }

    public function getList(int $userId, int $websiteId): array
    {
        $collection = $this->ticketCollectionFactory->create()
            ->addFieldToFilter('website_id', $websiteId);
        if ($userId) {
            $collection->addFieldToFilter('user_id', $userId);
        }
        return $collection->getItems();
    }

    public function save(TicketInterface $ticket): TicketInterface
    {
        try {
            $this->ticketResource->save($ticket);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $ticket;
    }

    public function delete(TicketInterface $ticket)
    {
        try {
            $ticketId = $ticket->getId();
            $this->ticketResource->delete($ticket);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()), $e);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('The "%1" product couldn\'t be removed.', $ticketId),
                $e
            );
        }

    }

}

