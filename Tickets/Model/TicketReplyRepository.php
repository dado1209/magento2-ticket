<?php

namespace Favicode\Tickets\Model;

use Exception;
use Favicode\Tickets\Api\TicketReplyRepositoryInterface;
use Favicode\Tickets\Model\ResourceModel\TicketReply\CollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;

class TicketReplyRepository implements TicketReplyRepositoryInterface
{
    private ResourceModel\TicketReply\CollectionFactory $ticketReplyCollectionFactory;
    private ResourceModel\TicketReply $ticketReplyResource;

    public function __construct(
        CollectionFactory                                 $ticketReplyCollectionFactory,
        \Favicode\Tickets\Model\ResourceModel\TicketReply $ticketReplyResource,
    )
    {
        $this->ticketReplyCollectionFactory = $ticketReplyCollectionFactory;
        $this->ticketReplyResource = $ticketReplyResource;
    }

    public function getList($ticketId, $websiteId): array
    {
        return $this->ticketReplyCollectionFactory->create()
            ->addFieldToFilter('website_id', $websiteId)
            ->addFieldToFilter('ticket_id', $ticketId)
            ->getItems();
    }

    public function save($ticketReply): void
    {
        try {
            $this->ticketReplyResource->save($ticketReply);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
    }
}
