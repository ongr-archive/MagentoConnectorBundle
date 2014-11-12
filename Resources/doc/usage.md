### Configuration

First of all you must config which shop you are going to work with: 

````yml
ongr_magento:
    shop: 1
````

*'1' refers to store_id from which to import data*

Also config database connection parameters in app/config/parameters.yml

Create MagentoSyncBundle add following configuration files: 

- **Resources/config/sync/category.yml:** 

````yml
parameters:
    ongr_magento.data_provider.category.class: ONGR\ConnectionsBundle\Doctrine\Provider\Provider
    ongr_magento.data_provider.category.entity_class: ONGR\MagentoSyncBundle\Entity\CatalogCategoryEntity

services:
    ongr_magento_sync.category.data_provider:
        class: %ongr_magento.data_provider.category.class%
        arguments:
            - @ongr_ddal.session.categoryModel
            - @doctrine.orm.default_entity_manager
            - %ongr_magento.data_provider.category.entity_class%
        tags:
            - { name: ongr_connections.doctrine.provider, type: category }
````

- **Resources/config/sync/content.yml:**

````yml
parameters:
    ongr_magento.data_provider.content.class: ONGR\MagentoConnectorBundle\Provider\ContentProvider
    ongr_magento.data_provider.content.entity_class: ONGR\MagentoSyncBundle\Entity\CmsPageStore

services:
    ongr_magento_sync.content.data_provider:
        class: %ongr_magento.data_provider.content.class%
        arguments:
            - @ongr_ddal.session.contentModel
            - @doctrine.orm.default_entity_manager
            - %ongr_magento.data_provider.content.entity_class%
        calls:
            - [setStoreId, [%ongr_magento.shop%]]
        tags:
            - { name: ongr_connections.doctrine.provider, type: content }
````

- **Resources/config/sync/product.yml:** 

````yml
parameters:
    ongr_magento.data_provider.product.class: ONGR\ConnectionsBundle\Doctrine\Provider\Provider
    ongr_magento.data_provider.product.entity_class: ONGR\MagentoSyncBundle\Entity\CatalogProductEntity

services:
    ongr_magento_sync.product.data_provider:
        class: %ongr_magento.data_provider.product.class%
        arguments:
            - @ongr_ddal.session.productModel
            - @doctrine.orm.default_entity_manager
            - %ongr_magento.data_provider.product.entity_class%
        tags:
            - { name: ongr_connections.doctrine.provider, type: product }
````

Add these configuration files to **DependencyInjection/ONGRMagentoSyncExtension.php** load method:

````php
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('sync/product.yml');
        $loader->load('sync/content.yml');
        $loader->load('sync/category.yml');
````

Add entities to **MagentoSyncBundle/Entity** entities should extend all ongr-magento bundle entities which you are going to use. For example CatalogCategoryEntity.php:

````php
<?php

namespace ONGR\MagentoSyncBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity as MagentoCategory;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_category_entity")
 */
class CatalogCategoryEntity extends MagentoCategory
{
}
````

### Commands

- Create ongr_sync_jobs table in database `app/console ongr:sync:table:create`

- Create triggers `app/console ongr:sync:triggers:create`

- Make initial sync from database `app/console ongr:sync:initial`

- For further synchronisation you can use command `app/console ongr:sync:execute`
