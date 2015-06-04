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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class ONGRMagentoConnectorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('ongr_magento.store_id', $config['store_id']);
        $container->setParameter('ongr_magento.shop_id', $config['shop_id']);
        $container->setParameter('ongr_magento.store_url', $config['url']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        if ($container->hasDefinition('ongr_magento.sync.cart')) {
            $cartDefinition = $container->getDefinition('ongr_magento.sync.cart');

            $cartDefinition->addMethodCall('setManager', [new Reference('es.manager.' . $config['es_manager'])]);
            $cartDefinition->addMethodCall('setRepositoryName', [$config['es_repositories']['product']]);
            $cartDefinition->addMethodCall('setCartRoute', [$config['cart_route']]);
        }

        $this->createImportServices($container, $config);
        $this->createSyncProviderServices($container, $config);
    }

    /**
     * Returns correct dependency injection alias.
     *
     * @return string
     */
    public function getAlias()
    {
        return 'ongr_magento';
    }

    /**
     * Creates import services.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function createImportServices(ContainerBuilder $container, array $config)
    {
        if (!$config['create_import_services']) {
            return;
        }

        $finish = new Definition(
            $config['finish_listener'],
            [
                new Reference('es.manager.' . $config['es_manager']),
            ]
        );
        foreach (['product', 'category', 'content'] as $type) {
            /*
             * Import source.
             */

            $importSource = new Definition(
                new Parameter('ongr_connections.import.source.class'),
                [
                    new Reference('doctrine.orm.' . $config['doctrine_manager']),
                    $config['doctrine_repositories'][$type],
                    new Reference('es.manager.' . $config['es_manager']),
                    $config['es_repositories'][$type],
                ]
            );
            $importSource->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.import.magento.{$type}.source",
                    'method' => 'onSource',
                ]
            );
            $container->setDefinition("ongr_magento.import.{$type}.source", $importSource);

            /*
             * Sync source.
             */

            $syncSource = new Definition(
                new Parameter('ongr_connections.sync.execute.source.class'),
                [
                    new Reference('doctrine.orm.' . $config['doctrine_manager']),
                    $config['doctrine_repositories'][$type],
                    new Reference('es.manager.' . $config['es_manager']),
                    $config['es_repositories'][$type],
                    new Reference('ongr_connections.sync.sync_storage'),
                ]
            );
            $syncSource->addMethodCall('setChunkSize', [$config['sync_chunk_size']]);
            $syncSource->addMethodCall('setShopId', [$config['shop_id']]);
            $syncSource->addMethodCall('setDocumentType', [$type]);
            $syncSource->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.sync.execute.magento.{$type}.source",
                    'method' => 'onSource',
                ]
            );
            $container->setDefinition("ongr_magento.sync.{$type}.source", $syncSource);

            /*
             * Import and sync modifier.
             */

            if ($type == 'product') {
                $arguments = [$config['store_id'], $config['shop_id']];
            } else {
                $arguments = [$config['shop_id']];
            }
            $modifier = new Definition(
                $config['modifiers'][$type],
                $arguments
            );
            $modifier->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.import.magento.{$type}.modify",
                    'method' => 'onModify',
                ]
            );
            $modifier->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.sync.execute.magento.{$type}.modify",
                    'method' => 'onModify',
                ]
            );
            $container->setDefinition("ongr_magento.import.{$type}.modify", $modifier);

            /*
             * Import consumer.
             */

            $importConsumer = new Definition(
                new Parameter('ongr_connections.import.consumer.class'),
                [
                    new Reference('es.manager.' . $config['es_manager']),
                ]
            );
            $importConsumer->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.import.magento.{$type}.consume",
                    'method' => 'onConsume',
                ]
            );
            $container->setDefinition("ongr_magento.import.{$type}.consume", $importConsumer);

            /*
             * Sync consumer.
             */

            $syncConsumer = new Definition(
                new Parameter('ongr_connections.sync.execute.consumer.class'),
                [
                    new Reference('es.manager.' . $config['es_manager']),
                    $config['es_repositories'][$type],
                    new Reference('ongr_connections.sync.sync_storage'),
                ]
            );
            $syncConsumer->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.sync.execute.magento.{$type}.consume",
                    'method' => 'onConsume',
                ]
            );
            $container->setDefinition("ongr_magento.sync.{$type}.consume", $syncConsumer);

            /*
             * Import and sync finish.
             */

            $finish->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.import.magento.{$type}.finish",
                    'method' => 'onFinish',
                ]
            );
            $finish->addTag(
                'kernel.event_listener',
                [
                    'event' => "ongr.pipeline.sync.execute.magento.{$type}.finish",
                    'method' => 'onFinish',
                ]
            );
        }
        $container->setDefinition('ongr_magento.import.finish', $finish);
    }

    /**
     * Creates Sync provider services.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function createSyncProviderServices(ContainerBuilder $container, array $config)
    {
        if (!$config['create_sync_provider_services']) {
            return;
        }

        $providerSource = new Definition(
            $config['sync']['source']['class'],
            [ new Reference($config['sync']['source']['provider']) ]
        );
        $providerSource->addTag(
            'kernel.event_listener',
            [
                'event' => 'ongr.pipeline.data_sync.magento.source',
                'method' => 'onSource',
            ]
        );
        $container->setDefinition('ongr_magento.sync.provide.source', $providerSource);

        $providerConsumer = new Definition(
            $config['sync']['consume']['class'],
            [ new Reference($config['sync']['consume']['extractor']) ]
        );
        $providerConsumer->addTag(
            'kernel.event_listener',
            [
                'event' => 'ongr.pipeline.data_sync.magento.consume',
                'method' => 'onConsume',
            ]
        );
        $container->setDefinition('ongr_magento.sync.provide.consume', $providerConsumer);
    }
}
