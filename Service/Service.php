<?php

namespace Msalsas\GdprConsentBannerBundle\Service;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class Service
{
    /**
     * @var integer
     */
    protected $timeToExpire;

    public function __construct($timeToExpire) {
        $this->timeToExpire = $timeToExpire;
    }

    public function getResponseWithAcceptedCookie()
    {
        $cookie = Cookie::create('msalsas-gdpr-consent-banner', 'accepted', strtotime('now + ' . $this->timeToExpire));
        $response = new Response("accepted");
        $response->headers->setCookie($cookie);

        return $response;
    }
}