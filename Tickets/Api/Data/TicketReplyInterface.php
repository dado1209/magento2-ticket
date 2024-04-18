<?php

namespace Favicode\Tickets\Api\Data;


interface TicketReplyInterface
{

    const TICKET_REPLY_ID = 'ticket_reply_id';
    const TICKET_ID = 'ticket_id';

    const WEBSITE_ID = 'website_id';
    const USER_ID = 'user_id';
    const SUMMARY = 'summary';

    const IS_USER_ADMIN = 'is_user_admin';

    public function getId();

    public function getUserId();

    public function getSummary();

    public function getWebsiteId();

    public function getTicketId();

    public function getIsUserAdmin();

    public function setSummary($summary);

    public function setUserId($userId);

    public function setId($id);

    public function setWebsiteId($websiteId);

    public function setTicketId($ticketId);

    public function setIsUserAdmin($isUserAdmin);


}
