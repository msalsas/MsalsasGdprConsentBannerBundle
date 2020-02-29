<?php

namespace Msalsas\GdprConsentBannerBundle\Tests;

use Msalsas\GdprConsentBannerBundle\Service\Service;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ServiceTest extends WebTestCase
{
    protected $translator;

    public function test_get_response_with_accepted_cookie_should_return_response_with_cookie()
    {
        $service = new Service('12 days');

        $cookie = Cookie::create('msalsas-gdpr-consent-banner', 'accepted', strtotime('now + 12 days'));
        $expectedResponse = new Response("accepted");
        $expectedResponse->headers->setCookie($cookie);

        $response = $service->getResponseWithAcceptedCookie();

        $this->assertEquals($expectedResponse , $response);
    }
}