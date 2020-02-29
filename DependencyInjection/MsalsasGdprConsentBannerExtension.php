<?php

namespace Msalsas\GdprConsentBannerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class MsalsasGdprConsentBannerExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $config = $this->processConfiguration(new Configuration(), $configs);
         $container->setParameter('msalsas_gdpr_consent_banner.has_translations', $config['has_translations']);
         $container->setParameter('msalsas_gdpr_consent_banner.css', $config['css']);
         $container->setParameter('msalsas_gdpr_consent_banner.fade_time', $config['fade_time']);
         $container->setParameter('msalsas_gdpr_consent_banner.text_message', $config['text_message']);
         $container->setParameter('msalsas_gdpr_consent_banner.accept_message', $config['accept_message']);
         $container->setParameter('msalsas_gdpr_consent_banner.time_to_expire', $config['time_to_expire']);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $twigConfig = [];
        $twigConfig['globals']['msalsas_gdpr_consent_banner']['has_translations'] = $config["has_translations"];
        $twigConfig['globals']['msalsas_gdpr_consent_banner']['css'] = $config["css"];
        $twigConfig['globals']['msalsas_gdpr_consent_banner']['fade_time'] = $config["fade_time"];
        $twigConfig['paths'][__DIR__.'/../Resources/views'] = "msalsas_gdpr_consent_banner";
        $twigConfig['paths'][__DIR__.'/../Resources/public'] = "msalsas_gdpr_consent_banner.public";
        $container->prependExtensionConfig('twig', $twigConfig);
    }

    public function getAlias()
    {
        return 'msalsas_gdpr_consent_banner';
    }
}