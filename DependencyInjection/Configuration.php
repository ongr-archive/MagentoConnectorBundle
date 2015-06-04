<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ongr_magento');

        $rootNode
            ->children()
                ->scalarNode('shop_id')
                    ->defaultValue(1)
                ->end()
                ->scalarNode('store_id')
                    ->defaultValue(0)
                ->end()
                ->scalarNode('es_manager')
                    ->defaultValue('default')
                ->end()
                ->scalarNode('doctrine_manager')
                    ->defaultValue('default_entity_manager')
                ->end()
                ->scalarNode('url')
                    ->defaultValue('localhost')
                ->end()
                ->arrayNode('es_repositories')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product')
                            ->defaultValue('ONGRMagentoConnectorBundle:ProductDocument')
                        ->end()
                        ->scalarNode('category')
                            ->defaultValue('ONGRMagentoConnectorBundle:CategoryDocument')
                        ->end()
                        ->scalarNode('content')
                            ->defaultValue('ONGRMagentoConnectorBundle:ContentDocument')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('doctrine_repositories')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product')
                            ->defaultValue('ONGRMagentoConnectorBundle:CatalogProductEntity')
                        ->end()
                        ->scalarNode('category')
                            ->defaultValue('ONGRMagentoConnectorBundle:CatalogCategoryEntity')
                        ->end()
                        ->scalarNode('content')
                            ->defaultValue('ONGRMagentoConnectorBundle:CmsPage')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('modifiers')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product')
                            ->defaultValue('ONGR\MagentoConnectorBundle\Modifier\ProductModifier')
                        ->end()
                        ->scalarNode('category')
                            ->defaultValue('ONGR\MagentoConnectorBundle\Modifier\CategoryModifier')
                        ->end()
                        ->scalarNode('content')
                            ->defaultValue('ONGR\MagentoConnectorBundle\Modifier\ContentModifier')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('finish_listener')
                    ->defaultValue('ONGR\MagentoConnectorBundle\EventListener\ImportFinishEventListener')
                ->end()
                ->arrayNode('sync')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('source')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('ONGR\ConnectionsBundle\EventListener\DataSyncSourceEventListener')
                                ->end()
                                ->scalarNode('provider')
                                    ->defaultValue('ongr_connections.sync.diff_provider.binlog_diff_provider')
                                ->end()
                          ->end()
                        ->end()
                        ->arrayNode('consume')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('ONGR\ConnectionsBundle\EventListener\DataSyncConsumeEventListener')
                                ->end()
                                ->scalarNode('extractor')
                                    ->defaultValue('ongr_connections.sync.extractor.doctrine_extractor')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->integerNode('sync_chunk_size')
                    ->defaultValue(1)
                    ->min(1)
                ->end()
                ->scalarNode('cart_route')
                    ->defaultNull()
                ->end()
                ->booleanNode('create_import_services')
                    ->defaultTrue()
                ->end()
                ->booleanNode('create_sync_provider_services')
                    ->defaultTrue()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
