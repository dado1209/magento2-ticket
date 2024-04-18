<?php

namespace Favicode\Tickets\Block\Adminhtml;

use Exception;
use Favicode\Tickets\Api\Data\TicketInterface;
use Favicode\Tickets\Api\TicketReplyRepositoryInterface;
use Favicode\Tickets\Api\TicketRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;


class GetTicket extends Template
{
    /**
     * @var TicketRepositoryInterface
     */
    private TicketRepositoryInterface $ticketRepository;
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;
    /**
     * @var StoreManagerInterface
     */

    private StoreManagerInterface $storeManager;
    /**
     * @var TicketReplyRepositoryInterface
     */

    private TicketReplyRepositoryInterface $ticketReplyRepository;
    /**
     * @var UserFactory
     */

    private UserFactory $userFactory;

    /**
     * GetTicket constructor.
     * @param Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param StoreManagerInterface $storeManager
     * @param TicketReplyRepositoryInterface $ticketReplyRepository
     * @param UserFactory $userFactory
     * @param array $data
     */
    public function __construct(Template\Context               $context,
                                TicketRepositoryInterface      $ticketRepository,
                                CustomerRepositoryInterface    $customerRepository,
                                StoreManagerInterface          $storeManager,
                                TicketReplyRepositoryInterface $ticketReplyRepository,
                                UserFactory                    $userFactory,

                                array                          $data = [])
    {
        $this->ticketRepository = $ticketRepository;
        $this->ticketReplyRepository = $ticketReplyRepository;
        $this->customerRepository = $customerRepository;
        $this->storeManager = $storeManager;
        $this->userFactory = $userFactory;
        parent::__construct($context, $data);

    }

    /**
     * @return TicketInterface|null
     */
    public function getTicketById(): ?TicketInterface
    {
        try {
            $ticketId = $this->getRequest()->getParam('ticket_id');
            $websiteId = $this->getRequest()->getParam('website_id');
            return $this->ticketRepository->getById($ticketId, $websiteId);
        } catch (Exception) {
            return null;
        }

    }

    /**
     * @param $userId
     * @return CustomerInterface|null
     */
    public function getCustomerById($userId): ?CustomerInterface
    {
        try {
            return $this->customerRepository->getById($userId);
        } catch (Exception) {
            return null;
        }
    }

    /**
     * @param $ticket
     * @return array
     */
    public function getTicketReplies($ticket): array
    {
        try {
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            return $this->ticketReplyRepository->getList($ticket->getId(), $websiteId);
        } catch (Exception) {
            return array();
        }
    }

    /**
     * @param $adminId
     * @return User|null
     */
    public function getAdminById($adminId): ?User
    {
        try {
            //todo: refactor later. this is deprecated
            return $this->userFactory->create()->load($adminId);
        } catch (Exception) {
            return null;
        }
    }
}
