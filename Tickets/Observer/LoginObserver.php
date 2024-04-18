<?php

namespace Favicode\Tickets\Observer;

class LoginObserver implements \Magento\Framework\Event\ObserverInterface
{
    private $session;
    private $response;
    private $urlInterface;

    public function __construct(\Magento\Customer\Model\Session      $session,
                                \Magento\Framework\App\Response\Http $response,
                                \Magento\Framework\UrlInterface      $urlInterface
    )
    {
        $this->session = $session;
        $this->response = $response;
        $this->urlInterface = $urlInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        # redirect user to login page if not logged in
        if (!$this->session->isLoggedIn()) {
            $url = $this->urlInterface->getUrl('customer/account/login');
            # redirect to /customer/account/login
            $this->response->setRedirect($url);
        }
    }
}
