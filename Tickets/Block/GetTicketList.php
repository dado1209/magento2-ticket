<?php

namespace Favicode\Tickets\Block;

use Favicode\Tickets\Api\TicketRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;


class GetTicketList extends Template
{
    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var TicketRepositoryInterface
     */
    private TicketRepositoryInterface $ticketRepository;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * GetTicketList constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param TicketRepositoryInterface $ticketRepository
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(Template\Context          $context,
                                Session                   $customerSession,
                                TicketRepositoryInterface $ticketRepository,
                                StoreManagerInterface     $storeManager,
                                array                     $data = [])
    {
        $this->customerSession = $customerSession;
        $this->ticketRepository = $ticketRepository;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);

    }

    /**
     * @return array
     */
    public function getTicketList(): array
    {
        try {
            $userId = $this->customerSession->getCustomerId();
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            return $this->ticketRepository->getList($userId, $websiteId);
        } catch (NoSuchEntityException) {
            return array();
        }
    }

}
