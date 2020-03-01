<?php

namespace Msalsas\GdprConsentBannerBundle\Tests;

use Msalsas\GdprConsentBannerBundle\DependencyInjection\MsalsasGdprConsentBannerExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Yaml\Parser;

class MsalsasGdprConsentBannerExtensionTest extends TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    protected function tearDown(): void
    {
        $this->configuration = null;
    }

    public function test_no_config_should_throw_exception()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getEmptyConfig();

        $this->expectException(InvalidConfigurationException::class);
        $loader->load(array($config), $this->configuration);
    }

    public function test_invalid_has_translations_should_throw_exception()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $config['has_translations'] = 5;

        $this->expectException(InvalidConfigurationException::class);
        $loader->load(array($config), $this->configuration);
    }

    public function test_invalid_fade_time_should_throw_exception()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $config['fade_time'] = 'foo';

        $this->expectException(InvalidConfigurationException::class);
        $loader->load(array($config), $this->configuration);
    }

    public function test_has_translations_should_be_true()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter(true, 'msalsas_gdpr_consent_banner.has_translations');
    }

    public function test_css_should_be_default()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter('default', 'msalsas_gdpr_consent_banner.css');
    }

    public function test_fade_time_should_be_2()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter(2, 'msalsas_gdpr_consent_banner.fade_time');
    }

    public function test_text_message_should_be_empty_string()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter('', 'msalsas_gdpr_consent_banner.text_message');
    }

    public function test_accept_message_should_be_empty_string()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter('', 'msalsas_gdpr_consent_banner.accept_message');
    }

    public function test_time_to_expire_should_be_30_days()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter('30 days', 'msalsas_gdpr_consent_banner.time_to_expire');
    }

    public function test_twig_config()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MsalsasGdprConsentBannerExtension();
        $config = $this->getFullConfig();

        $this->configuration->prependExtensionConfig('msalsas_gdpr_consent_banner', $config);
        $loader->prepend($this->configuration);

        $twigConfig = $this->configuration->getExtensionConfig('twig');
        $this->assertTrue(isset($twigConfig) && is_array($twigConfig));
        $this->assertTrue(isset($twigConfig[0]['globals']['msalsas_gdpr_consent_banner']['has_translations']));
        $this->assertTrue($twigConfig[0]['globals']['msalsas_gdpr_consent_banner']['has_translations']);
        $this->assertTrue(isset($twigConfig[0]['globals']['msalsas_gdpr_consent_banner']['css']));
        $this->assertEquals("default", $twigConfig[0]['globals']['msalsas_gdpr_consent_banner']['css']);
        $this->assertTrue(isset($twigConfig[0]['globals']['msalsas_gdpr_consent_banner']['fade_time']));
        $this->assertEquals(2, $twigConfig[0]['globals']['msalsas_gdpr_consent_banner']['fade_time']);

        $dir = __DIR__;
        $mainDir = substr(__DIR__, 0, strpos(__DIR__, '/Tests') );
        $this->assertTrue(isset($twigConfig[0]['paths'][$mainDir . '/DependencyInjection/../Resources/views']));
        $this->assertTrue($twigConfig[0]['paths'][$mainDir . '/DependencyInjection/../Resources/views'] === "msalsas_gdpr_consent_banner");
        $this->assertTrue(isset($twigConfig[0]['paths'][$mainDir . '/DependencyInjection/../Resources/public']));
        $this->assertTrue($twigConfig[0]['paths'][$mainDir . '/DependencyInjection/../Resources/public'] === "msalsas_gdpr_consent_banner.public");
    }

    /**
     * getEmptyConfig.
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * getFullConfig.
     *
     * @return array
     */
    protected function getFullConfig()
    {
        $yaml = <<<EOF
has_translations: true
css: default
fade_time: 2
text_message: ''
accept_message: ''
time_to_expire: 30 days
EOF;

        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertSame($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }
}