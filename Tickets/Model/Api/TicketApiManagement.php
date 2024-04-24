<?php

namespace Favicode\Tickets\Model\Api;

use Favicode\Tickets\Api\Data\TicketInterface;
use Favicode\Tickets\Api\Data\TicketSearchResultsInterfaceFactory;
use Favicode\Tickets\Api\TicketApiManagementInterface;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Favicode\Tickets\Model\ResourceModel\Ticket\CollectionFactory;
use JsonSchema\Exception\ValidationException;
use Laminas\Crypt\Exception\NotFoundException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\App\RequestInterface;
use Favicode\Tickets\Model\TicketFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class TicketApiManagement implements TicketApiManagementInterface
{
    private TicketRepositoryInterface $ticketRepository;
    private RequestInterface $request;

    private TicketFactory $ticketModelFactory;

    private CollectionFactory $ticketCollectionFactory;

    private TicketSearchResultsInterfaceFactory $searchResultsFactory;

    private CollectionProcessorInterface $collectionProcessor;


    public function __construct(TicketRepositoryInterface           $ticketRepository, RequestInterface $request,
                                TicketFactory                       $ticketModelFactory,
                                CollectionFactory                   $ticketCollectionFactory,
                                TicketSearchResultsInterfaceFactory $searchResultsFactory,
                                CollectionProcessorInterface        $collectionProcessor
    )
    {
        $this->ticketRepository = $ticketRepository;
        $this->request = $request;
        $this->ticketModelFactory = $ticketModelFactory;
        $this->ticketCollectionFactory = $ticketCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

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
    public function getById(int $ticketId, int $websiteId): TicketInterface
    {
        //add some business logic here..
        $ticket = $this->ticketRepository->getById($ticketId, $websiteId);
        if (empty($ticket->getId())) {
            throw new NotFoundException('Ticket not found');
        }
        return $ticket;
    }

    /**
     * create ticket Api .
     *
     * @param int $websiteId
     *
     * @return TicketInterface
     * @api
     *
     */
    public function create(int $websiteId): TicketInterface
    {
        //todo: find out how magento sets response code for exceptions
        $ticket = $this->ticketModelFactory->create();
        $postValues = json_decode($this->request->getContent());
        //add some validation logic later
        $title = $postValues->title;
        $summary = $postValues->summary;
        if (empty($title) || empty($summary)) {
            throw new ValidationException('Title and summary are required fields', 409);
        }
        $ticket->setTitle($title);
        $ticket->setSummary($summary);
        $ticket->setUserId(1);
        $ticket->setWebsiteId($websiteId);
        return $this->ticketRepository->save($ticket);
    }


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
    public function update(int $ticketId, int $websiteId): TicketInterface
    {
        $ticket = $this->ticketRepository->getById($ticketId, $websiteId);
        $postValues = json_decode($this->request->getContent());
        if (!empty($postValues->title)) {
            $ticket->setTitle($postValues->title);
        }
        if (!empty($postValues->summary)) {
            $ticket->setSummary($postValues->summary);
        }
        $this->ticketRepository->save($ticket);
        return $ticket;
    }

    /**
     * get ticket list Api data.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResultsInterface
     * @api
     *
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->ticketCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getData());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete ticket
     *
     * @param TicketInterface $ticket
     * @return bool Will returned True if deleted
     * @throws StateException
     * @api
     */
    public function delete(TicketInterface $ticket): bool
    {
        $this->ticketRepository->delete($ticket);
        return true;
    }

    /**
     * @param string $ticketId
     * @return bool Will returned True if deleted
     * @throws NoSuchEntityException
     * @throws StateException
     * @api
     */
    public function deleteById($ticketId): bool
    {
        $ticket = $this->ticketRepository->getById($ticketId, 0);
        return $this->delete($ticket);
    }
}
