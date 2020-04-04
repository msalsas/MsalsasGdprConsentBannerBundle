<?php

namespace Msalsas\GdprConsentBannerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder $builder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('msalsas_gdpr_consent_banner');

        $rootNode = $builder->getRootNode();
        $rootNode->children()
            ->booleanNode('has_translations')
                ->defaultValue(true)
            ->end()
            ->scalarNode('css')
                ->defaultValue('default')
            ->end()
            ->integerNode('fade_time')
                ->defaultValue(1)
            ->end()
            ->scalarNode('text_message')
                ->defaultValue('')
            ->end()
            ->scalarNode('accept_message')
                ->defaultValue('')
            ->end()
            ->scalarNode('time_to_expire')
                ->defaultValue('30 days')
            ->end()
            ->end();

        return $builder;
    }
}
