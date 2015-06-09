Magento Connector Installation
==============================

Step 1.
-------

Download the bundle.

.. code-block:: bash

    php composer.phar require ongr/magento-connector-bundle:dev-master
    php composer.phar require --dev sensio/generator-bundle

..

Step 2.
-------

Register bundle and its dependencies in ``AppKernel.php``

.. code-block:: php

    new ONGR\ConnectionsBundle\ONGRConnectionsBundle(),
    new ONGR\MagentoConnectorBundle\ONGRMagentoConnectorBundle(),

    // ...

    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
    }

..

Step 3.
-------

Create bundle for magento sync logic.
Then generate required classes for sync.

.. code-block:: bash

    php app/console ongr:magento:generate:entities --configure AcmeMySyncBundle

..

``--configure`` option will add ongr_magento configuration with new new entities and documents to app/config/config.yml.

Step 4.
-------

Configure the bundle.

Configuration with default values:

.. code-block:: yaml

    ongr_magento:
        store_id: 0  # Store id in magento shop to use when importing products.
        shop_id: 1   # Which storage to use when syncing documents.
        es_manager: default # ESB manager used for sync and import.
        doctrine_manager: default_entity_manager # Doctrine manager used for sync and import.
        url: localhost # Url to actual magento shop. Used for login and cart functionality.
        cart_route: ~ # Users will be redirected here after adding product to magento cart.

        # Doctrine entities used for sync and import.
        # These are super mapped entities which should be extended when using connector.
        doctrine_repositories:
            product: ONGRMagentoConnectorBundle:CatalogProductEntity
            category: ONGRMagentoConnectorBundle:CatalogCategoryEntity
            content: ONGRMagentoConnectorBundle:CmsPage

        # Elastic search documents used for sync and import.
        # These are abstract and should be extended when using connector.
        es_repositories: # Elastic search documents used for sync and import.
            product: ONGRMagentoConnectorBundle:Product
            category: ONGRMagentoConnectorBundle:Category
            content: ONGRMagentoConnectorBundle:Content

        # Classes responsible for converting doctrine entities to es documents.
        # In most cases default ones should be used and additional ones created as needed
        # More information can be found in `Data import related functionality`
        modifiers:
            product: ONGR\MagentoConnectorBundle\Modifier\ProductModifier
            category: ONGR\MagentoConnectorBundle\Modifier\CategoryModifier
            content: ONGR\MagentoConnectorBundle\Modifier\ContentModifier

        # Class responsible for committing changes to ES.
        finish_listener: ONGR\MagentoConnectorBundle\EventListener\ImportFinishEventListener

        sync: # configuration for getting sync data to sync storage.
            source:
                class: ONGR\ConnectionsBundle\EventListener\DataSyncSourceEventListener
                provider: ongr_connections.sync.diff_provider.binlog_diff_provider
            consume:
                class: ONGR\ConnectionsBundle\EventListener\DataSyncConsumeEventListener
                extractor: ongr_connections.sync.extractor.doctrine_extractor

        sync_chunk_size: 1
        create_import_services: true # If set to false import and sync services will not be created.
        create_sync_provider_services: true # If set to false sync provider services will not be created.

..

Step 5.
-------

Configure sync storage:

.. code-block:: bash

    app/console ongr:sync:storage:create --shop-id=1 mysql
    app/console ongr:sync:provide:parameter last_sync_date --set="2015-01-01 00:00:00"

..

Now it is possible to use this bundle and following commands will be available:

- app/console ongr:import:full magento.product
- app/console ongr:import:full magento.category
- app/console ongr:import:full magento.content
- app/console ongr:sync:provide magento
- app/console ongr:sync:execute magento.product
- app/console ongr:sync:execute magento.category
- app/console ongr:sync:execute magento.content

Things to do
------------

- Setup ``ongr-io/MagentoSyncModule`` in magento store
- Implement cart and user functionality with help of ``ONGR\MagentoConnectorBundle\Magento\Cart``
  and ``ONGR\MagentoConnectorBundle\Magento\Customer``
- Implement frontend logic ( Example in ``ongr-io/MagentoExperimental`` )
