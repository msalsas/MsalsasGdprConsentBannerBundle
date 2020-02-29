<?php

namespace Msalsas\GdprConsentBannerBundle\Controller;

use Msalsas\GdprConsentBannerBundle\Service\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MsalsasGdprConsentBannerController extends AbstractController
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function acceptGdprConsentBanner()
    {
        return $this->service->getResponseWithAcceptedCookie();
    }
}