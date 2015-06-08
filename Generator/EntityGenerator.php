<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Class EntityGenerator.
 */
class EntityGenerator extends Generator
{
    /**
     * @var BundleInterface
     */
    private $connectorBundle;

    /**
     * @var string
     */
    private $appDirectory;

    /**
     * Constructor.
     *
     * @param BundleInterface $connectorBundle
     * @param string          $appDirectory
     */
    public function __construct(BundleInterface $connectorBundle, $appDirectory)
    {
        $this->connectorBundle = $connectorBundle;
        $this->appDirectory = $appDirectory;
    }

    /**
     * Generates Entities.
     *
     * @param BundleInterface $bundle
     * @param bool            $configure
     */
    public function generate(BundleInterface $bundle, $configure)
    {
        $this->setSkeletonDirs($this->connectorBundle->getPath() . '/Resources/skeleton/');

        foreach ($this->getEntities() as $table => $entity) {
            $namespace = $bundle->getNamespace() . '\\Entity';
            $entityClass = $namespace . '\\' . $entity;
            $entityPath = $bundle->getPath() . '/Entity/' . $entity . '.php';
            if (file_exists($entityPath)) {
                throw new \RuntimeException(sprintf('Entity "%s" already exists.', $entityClass));
            }
            $this->renderFile(
                'entity/Entity.php.twig',
                $entityPath,
                [
                    'namespace' => $namespace,
                    'entity_name' => $entity,
                    'entity_table' => $table,
                ]
            );
        }

        foreach ($this->getDocuments() as $type => $document) {
            $namespace = $bundle->getNamespace() . '\\Document';
            $documentClass = $namespace . '\\' . $document;
            $documentPath = $bundle->getPath() . '/Document/' . $document . '.php';
            if (file_exists($documentPath)) {
                throw new \RuntimeException(sprintf('Document "%s" already exists.', $documentClass));
            }
            $this->renderFile(
                'document/Document.php.twig',
                $documentPath,
                [
                    'namespace' => $namespace,
                    'document_name' => $document,
                    'document_type' => $type,
                ]
            );
        }

        if ($configure) {
            $this->addConfiguration($bundle->getName());
        }
    }

    /**
     * Adds connector configuration to app config.
     *
     * @param string $bundleName
     */
    protected function addConfiguration($bundleName)
    {
        $contents = "\nongr_magento:\n    doctrine_repositories:\n"
            . "        product: {$bundleName}:CatalogProductEntity\n"
            . "        category: {$bundleName}:CatalogCategoryEntity\n"
            . "        content: {$bundleName}:CmsPage\n"
            . "    es_repositories:\n"
            . "        product: {$bundleName}:Product\n"
            . "        category: {$bundleName}:Category\n"
            . "        content: {$bundleName}:Content\n";

        file_put_contents(
            $this->appDirectory . '/config/config.yml',
            $contents,
            FILE_APPEND
        );
    }

    /**
     * List of entities to generate.
     *
     * @return array
     */
    private function getEntities()
    {
        return [
            'catalog_category_entity' => 'CatalogCategoryEntity',
            'catalog_category_entity_int' => 'CatalogCategoryEntityInt',
            'catalog_category_entity_varchar' => 'CatalogCategoryEntityVarchar',
            'catalog_category_product' => 'CatalogCategoryProduct',
            'catalog_product_entity' => 'CatalogProductEntity',
            'catalog_product_entity_int' => 'CatalogProductEntityInt',
            'catalog_product_entity_text' => 'CatalogProductEntityText',
            'catalog_product_entity_varchar' => 'CatalogProductEntityVarchar',
            'catalog_product_index_price' => 'CatalogProductIndexPrice',
            'catalog_product_website' => 'CatalogProductWebsite',
            'cms_page' => 'CmsPage',
            'cms_page_store' => 'CmsPageStore',
            'eav_attribute' => 'EavAttribute',
        ];
    }

    /**
     * List of documents to generate.
     *
     * @return array
     */
    private function getDocuments()
    {
        return [
            'category' => 'CategoryDocument',
            'content' => 'ContentDocument',
            'product' => 'ProductDocument',
        ];
    }
}
