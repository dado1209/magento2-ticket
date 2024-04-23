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

    /**
     * get ticket Api data.
     *
     * @return int
     * @api
     *
     */
    public function getId();

    /**
     * get ticket Api data.
     *
     * @return int
     * @api
     *
     */
    public function getUserId();

    /**
     * get ticket Api data.
     *
     * @return string
     * @api
     *
     */
    public function getTitle();

    /**
     * get ticket Api data.
     *
     * @return string
     * @api
     *
     */
    public function getSummary();

    /**
     * get ticket Api data.
     *
     * @return int
     * @api
     *
     */
    public function getOrderId();

    /**
     * get ticket Api data.
     *
     * @return bool
     * @api
     *
     */
    public function getIsOpen();

    /**
     * get ticket Api data.
     *
     * @return int
     * @api
     *
     */
    public function getWebsiteId();

    /**
     * get ticket Api data.
     *
     * @param string $summary
     *
     * @return void
     * @api
     */
    public function setSummary($summary);

    /**
     * get ticket Api data.
     *
     * @param int $userId
     *
     * @return void
     * @api
     */
    public function setUserId($userId);

    /**
     * get ticket Api data.
     *
     * @param int $orderId
     *
     * @return void
     * @api
     */
    public function setOrderId($orderId);

    /**
     * get ticket Api data.
     *
     * @param int $id
     *
     * @return void
     * @api
     */
    public function setId($id);

    /**
     * get ticket Api data.
     *
     * @param string $title
     *
     * @return void
     * @api
     */
    public function setTitle($title);

    /**
     * get ticket Api data.
     *
     * @param int $websiteId
     *
     * @return void
     * @api
     */
    public function setWebsiteId($websiteId);

    /**
     * get ticket Api data.
     *
     * @param bool $is_open
     *
     * @return void
     * @api
     */
    public function setIsOpen($is_open);

}
