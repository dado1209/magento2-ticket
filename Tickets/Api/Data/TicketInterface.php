<?php

namespace Favicode\Tickets\Api\Data;


interface TicketInterface
{

    const TICKET_ID = 'ticket_id';
    const ORDER_ID = 'order_id';
    const WEBSITE_ID = 'website_id';
    const USER_ID = 'user_id';

    const TITLE = 'title';

    const SUMMARY = 'summary';

    const IS_OPEN = 'is_open';

    public function getId();

    public function getUserId();

    public function getTitle();

    public function getSummary();

    public function getOrderId();

    public function getIsOpen();

    public function getWebsiteId();

    public function setSummary($summary);

    public function setUserId($userId);

    public function setOrderId($orderId);

    public function setId($id);

    public function setTitle($title);

    public function setWebsiteId($websiteId);

    public function setIsOpen($is_open);

}
