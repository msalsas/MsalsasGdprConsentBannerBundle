Getting Started With MsalsasGdprConsentBannerBundle
===================================================

This bundle provides a GDPR consent banner.

Prerequisites
-------------

This version of the bundle requires Symfony 4.0+.

Configuration
-------------

.. code-block:: yaml

    msalsas_gdpr_consent_banner:
        css: default [default|none]
        has_translations: false [true|false]
        text_message: "By using our site, you acknowledge that you have read and understand our <a class="msalsas_gdpr_consent_banner_link" target="_blank" href="https://{$domain}/legal/cookie-policy">Cookie Policy</a>,
            \ <a class="msalsas_gdpr_consent_banner_link" target="_blank" href="https://{$domain}/legal/privacy-policy">Privacy Policy</a>,
            \ and our <a class="msalsas_gdpr_consent_banner_link" target="_blank" href="https://{$domain}/legal/terms-of-service/public">Terms of Service</a>." [{message}|{key}]
        accept_message: "OK" [{message}|{key}]
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

