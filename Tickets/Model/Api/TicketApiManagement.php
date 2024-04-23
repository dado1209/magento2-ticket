<?php

namespace Favicode\Tickets\Model\Api;

use Favicode\Tickets\Api\Data\TicketInterface;
use Favicode\Tickets\Api\TicketApiManagementInterface;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Favicode\Tickets\Model\TicketFactory;

class TicketApiManagement implements TicketApiManagementInterface
{
    private TicketRepositoryInterface $ticketRepository;
    private RequestInterface $request;

    private TicketFactory $ticketModelFactory;

    public function __construct(TicketRepositoryInterface $ticketRepository, RequestInterface $request,
                                TicketFactory             $ticketModelFactory,
                                )
    {
        $this->ticketRepository = $ticketRepository;
        $this->request = $request;
        $this->ticketModelFactory = $ticketModelFactory;
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
    public function getTicketById(int $ticketId, int $websiteId): TicketInterface
    {
        //add some business logic here..
        return $this->ticketRepository->getById($ticketId, $websiteId);
    }

    /**
     * get ticket Api data.
     *
     * @param int $websiteId
     *
     * @return array
     * @api
     *
     */
    public function createTicket(int $websiteId): array
    {
        //todo: find out how magento sets response code for exceptions
        $ticket = $this->ticketModelFactory->create();
        $postValues = json_decode($this->request->getContent());
        //add some validation logic later
        $title = $postValues->title;
        $summary = $postValues->summary;

        $ticket->setTitle($title);
        $ticket->setSummary($summary);
        $ticket->setUserId(1);
        $ticket->setWebsiteId($websiteId);
        $this->ticketRepository->save($ticket);
        return ['message' => 'ticket created'];
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
    public function updateTicketById(int $ticketId, int $websiteId): TicketInterface
    {
        $ticket = $this->ticketRepository->getById($ticketId, $websiteId);
        $postValues = json_decode($this->request->getContent());
        if(!empty($postValues->title)){
            $ticket->setTitle($postValues->title);
        }
        if(!empty($postValues->summary)){
            $ticket->setSummary($postValues->summary);
        }
        $this->ticketRepository->save($ticket);
        return $ticket;
    }
    /**
     * get ticket list Api data.
     *
     * @param int $websiteId
     *
     * @return array
     * @api
     *
     */
    public function getTickets(int $websiteId): array
    {
        $tickets = [];
        $ticketObjects = $this->ticketRepository->getList(0, $websiteId);

        foreach ($ticketObjects as $ticketObject) {
            $tickets[] = $ticketObject->getData();
        }
        //todo: add 'data' key for return value
        return $tickets;
    }


}
