<?php

namespace Favicode\Tickets\Model;

use Favicode\Tickets\Api\Data\TicketInterface;
use Magento\Framework\Model\AbstractModel;

class Ticket extends AbstractModel implements TicketInterface
{
    /**
     * Initialize ticket Model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Ticket::class);
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function getSummary()
    {
        return $this->getData(self::SUMMARY);
    }

    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    public function setSummary($summary)
    {
        $this->setData(self::SUMMARY, $summary);
    }

    public function setUserId($userId)
    {
        $this->setData(self::USER_ID, $userId);
    }

    public function setOrderId($orderId)
    {
        $this->setData(self::ORDER_ID, $orderId);
    }

    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
    }

    public function setWebsiteId($websiteId)
    {
        $this->setData(self::WEBSITE_ID, $websiteId);
    }

    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    public function getIsOpen()
    {
        return $this->getData(self::IS_OPEN);
    }

    public function setIsOpen($is_open)
    {
        $this->setData(self::IS_OPEN, $is_open);
    }
}
