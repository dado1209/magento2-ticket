<?php

namespace Favicode\Tickets\Model;

use Favicode\Tickets\Api\Data\TicketReplyInterface;
use Magento\Framework\Model\AbstractModel;

class TicketReply extends AbstractModel implements TicketReplyInterface
{
    /**
     * Initialize ticket reply Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\TicketReply::class);
    }

    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    public function getSummary()
    {
        return $this->getData(self::SUMMARY);
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

    public function setWebsiteId($websiteId)
    {
        $this->setData(self::WEBSITE_ID, $websiteId);
    }

    public function getTicketId()
    {
        return $this->getData(self::TICKET_ID);
    }

    public function setTicketId($ticketId)
    {
        $this->setData(self::TICKET_ID, $ticketId);
    }

    public function getIsUserAdmin()
    {
        return $this->getData(self::IS_USER_ADMIN);
    }

    public function setIsUserAdmin($isUserAdmin)
    {
        $this->setData(self::IS_USER_ADMIN, $isUserAdmin);
    }
}
