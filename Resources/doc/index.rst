Getting Started With MsalsasGdprConsentBannerBundle
===================================================

This bundle provides a GDPR consent banner.

Prerequisites
-------------

This version of the bundle requires Symfony 4.0+.

Install
-------

.. code-block:: bash

'' composer require msalsas/gdpr-consent-banner-bundle

Configuration
-------------

.. code-block:: yaml

    msalsas_gdpr_consent_banner:
        css: default # [default|none]
        has_translations: true # [true|false]
        text_message: '' # [{message}] Only if has_translations is false
        accept_message: '' # [{message}] Only if has_translations is false
        fade_time: 2
        time_to_expire: 30 days

Routing
-------

.. code-block:: yaml

    accept_gdpr_consent_banner:
      path: /accept-gdpr-consent-banner
      controller: Msalsas\GdprConsentBannerBundle\Controller\MsalsasGdprConsentBannerController:acceptGdprConsentBanner
      methods: POST

Usage
-----

Include this line in the footer of your base twig file

.. code-block:: twig

    {% include "@msalsas_gdpr_consent_banner/msalsas_gdpr_consent_banner_widget.html.twig" %}

