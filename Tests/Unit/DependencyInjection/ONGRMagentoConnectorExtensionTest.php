<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Unit\DependencyInjection;

use ONGR\MagentoConnectorBundle\DependencyInjection\ONGRMagentoConnectorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ONGRMagentoConnectorExtensionTest.
 */
class ONGRMagentoConnectorExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    private function getDefaultConfig()
    {
        return [
            'shop_id' => 1,
            'store_id' => 0,
            'es_manager' => 'default',
            'doctrine_manager' => 'default_entity_manager',
            'url' => 'localhost',
            'es_repositories' => [
                'product' => 'ONGRMagentoConnectorBundle:ProductDocument',
                'category' => 'ONGRMagentoConnectorBundle:CategoryDocument',
                'content' => 'ONGRMagentoConnectorBundle:ContentDocument',
            ],
            'doctrine_repositories' => [
                'product' => 'ONGRMagentoConnectorBundle:CatalogProductEntity',
                'category' => 'ONGRMagentoConnectorBundle:CatalogCategoryEntity',
                'content' => 'ONGRMagentoConnectorBundle:CmsPage',
            ],
            'modifiers' => [
                'product' => 'ONGR\\MagentoConnectorBundle\\Modifier\\ProductModifier',
                'category' => 'ONGR\\MagentoConnectorBundle\\Modifier\\CategoryModifier',
                'content' => 'ONGR\\MagentoConnectorBundle\\Modifier\\ContentModifier',
            ],
            'finish_listener' => 'ONGR\\MagentoConnectorBundle\\EventListener\\ImportFinishEventListener',
            'sync' => [
                'source' => [
                    'class' => 'ONGR\\ConnectionsBundle\\EventListener\\DataSyncSourceEventListener',
                    'provider' => 'ongr_connections.sync.diff_provider.binlog_diff_provider',
                ],
                'consume' => [
                    'class' => 'ONGR\\ConnectionsBundle\\EventListener\\DataSyncConsumeEventListener',
                    'extractor' => 'ongr_connections.sync.extractor.doctrine_extractor',
                ],
            ],
            'sync_chunk_size' => 1,
            'cart_route' => null,
            'create_import_services' => true,
            'create_sync_provider_services' => true,
        ];
    }

    /**
     * @return array
     */
    private function getDefaultTestDefinitions()
    {
        return [
            'ongr_magento.import.product.source' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.import.magento.product.source' ],
            ],
            'ongr_magento.import.category.source' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.import.magento.category.source' ],
            ],
            'ongr_magento.import.content.source' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.import.magento.content.source' ],
            ],
            'ongr_magento.sync.product.source' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.sync.execute.magento.product.source' ],
            ],
            'ongr_magento.sync.category.source' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.sync.execute.magento.category.source' ],
            ],
            'ongr_magento.sync.content.source' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.sync.execute.magento.content.source' ],
            ],
            'ongr_magento.import.product.modify' => [
                'created' => true,
                'events' => [
                    'ongr.pipeline.import.magento.product.modify',
                    'ongr.pipeline.sync.execute.magento.product.modify',
                ],
            ],
            'ongr_magento.import.category.modify' => [
                'created' => true,
                'events' => [
                    'ongr.pipeline.import.magento.category.modify',
                    'ongr.pipeline.sync.execute.magento.category.modify',
                ],
            ],
            'ongr_magento.import.content.modify' => [
                'created' => true,
                'events' => [
                    'ongr.pipeline.import.magento.content.modify',
                    'ongr.pipeline.sync.execute.magento.content.modify',
                ],
            ],
            'ongr_magento.import.product.consume' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.import.magento.product.consume' ],
            ],
            'ongr_magento.import.category.consume' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.import.magento.category.consume' ],
            ],
            'ongr_magento.import.content.consume' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.import.magento.content.consume' ],
            ],
            'ongr_magento.sync.product.consume' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.sync.execute.magento.product.consume' ],
            ],
            'ongr_magento.sync.category.consume' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.sync.execute.magento.category.consume' ],
            ],
            'ongr_magento.sync.content.consume' => [
                'created' => true,
                'events' => [ 'ongr.pipeline.sync.execute.magento.content.consume' ],
            ],
            'ongr_magento.import.finish' => [
                'created' => true,
                'events' => [
                    'ongr.pipeline.import.magento.product.finish',
                    'ongr.pipeline.import.magento.category.finish',
                    'ongr.pipeline.import.magento.content.finish',
                    'ongr.pipeline.sync.execute.magento.product.finish',
                    'ongr.pipeline.sync.execute.magento.category.finish',
                    'ongr.pipeline.sync.execute.magento.content.finish',
                ],
            ],
            'ongr_magento.sync.provide.source' => [
                'created' => true,
                'events' => [
                    'ongr.pipeline.data_sync.magento.source',
                ],
            ],
            'ongr_magento.sync.provide.consume' => [
                'created' => true,
                'events' => [
                    'ongr.pipeline.data_sync.magento.consume',
                ],
            ],
        ];
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    private function getConfig(array $overrides = [])
    {
        return array_merge($this->getDefaultConfig(), $overrides);
    }

    /**
     * Provider config data for tests.
     *
     * @return array
     */
    public function configProvider()
    {
        $tests = [];
        // Case #0. Default config.
        $tests[] = [ $this->getDefaultConfig(), $this->getDefaultTestDefinitions()];

        // Case #1. Do not create provider services.
        $definitions = $this->getDefaultTestDefinitions();
        $definitions['ongr_magento.sync.provide.source']['created'] = false;
        $definitions['ongr_magento.sync.provide.consume']['created'] = false;
        $tests[] = [ $this->getConfig(['create_sync_provider_services' => false]), $definitions];

        // Case #2. Do not create import services.
        $definitions = $this->getDefaultTestDefinitions();
        foreach ($definitions as $key => $definition) {
            $definitions[$key]['created'] = false;
        }
        $definitions['ongr_magento.sync.provide.source']['created'] = true;
        $definitions['ongr_magento.sync.provide.consume']['created'] = true;
        $tests[] = [ $this->getConfig(['create_import_services' => false]), $definitions];

        // Case #3. Do not create services.
        $definitions = $this->getDefaultTestDefinitions();
        foreach ($definitions as $key => $definition) {
            $definitions[$key]['created'] = false;
        }
        $tests[] = [
            $this->getConfig(
                [
                    'create_import_services' => false,
                    'create_sync_provider_services' => false,
                ]
            ),
            $definitions,
        ];

        return $tests;
    }

    /**
     * Tests whether services are created correctly.
     *
     * @param array $config
     * @param array $testDefinitions
     *
     * @dataProvider configProvider
     */
    public function testServiceCreation($config, $testDefinitions)
    {
        $extension = new ONGRMagentoConnectorExtension();
        $container = new ContainerBuilder();

        $extension->load([$config], $container);

        foreach ($testDefinitions as $name => $testDefinition) {
            $this->assertEquals(
                $testDefinition['created'],
                $container->hasDefinition($name),
                "Service '{$name}' creation is invalid"
            );
            if (!$testDefinition['created']) {
                continue;
            }
            $definition = $container->getDefinition($name);
            $tags = $definition->getTag('kernel.event_listener');
            $this->assertSameSize($testDefinition['events'], $tags);
            foreach ($tags as $tag) {
                $this->assertContains($tag['event'], $testDefinition['events']);
            }
        }
    }
}
