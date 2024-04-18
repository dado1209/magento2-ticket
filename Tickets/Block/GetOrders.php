<?php

namespace Favicode\Tickets\Block;

use Exception;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;


class GetOrders extends Template
{
    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $orderCollectionFactory;

    /**
     * GetOrders constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param CollectionFactory $orderCollectionFactory
     * @param array $data
     */
    public function __construct(Template\Context  $context,
                                Session           $customerSession,
                                CollectionFactory $orderCollectionFactory,

                                array             $data = [])
    {
        $this->customerSession = $customerSession;
        $this->orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context, $data);

    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        try {
            $customerId = $this->customerSession->getCustomerId();
            $orders = $this->orderCollectionFactory->create()
                ->addFieldToFilter('customer_id', [
                    'eq' => $customerId
                ])->getItems();
            return $orders ?: array();
        } catch (Exception) {
            return array();
        }

    }


}
