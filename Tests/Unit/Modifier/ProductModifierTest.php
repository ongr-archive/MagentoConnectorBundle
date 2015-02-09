<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\MagentoConnectorBundle\Document\CategoryObject;
use ONGR\MagentoConnectorBundle\Document\PriceObject;
use ONGR\MagentoConnectorBundle\Document\ProductDocument;
use ONGR\MagentoConnectorBundle\Document\UrlObject;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryProduct;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductIndexPrice;
use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier;
use ONGR\MagentoConnectorBundle\Modifier\ProductModifier;
use ONGR\MagentoConnectorBundle\Tests\Unit\Modifier\Helper\ModifierHelperTrait;

class ProductModifierTest extends \PHPUnit_Framework_TestCase
{
    use ModifierHelperTrait;

    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $shopId = 0;
        $store_id = 1;

        $data = [
            [
                'attributeId' => ProductModifier::PRODUCT_DESCRIPTION,
                'value' => 'description',
                'store' => $shopId,
            ],
            [
                'attributeId' => ProductModifier::PRODUCT_SHORT_DESCRIPTION,
                'value' => 'short description',
                'store' => $shopId,
            ],
            [
                'attributeId' => 3,
                'value' => 'nothing',
                'store' => $shopId,
            ],
            [
                'attributeId' => 3,
                'value' => 'nothing',
                'store' => $shopId + 1,
            ],
        ];

        $textAttributes = $this->getAttributesArray(
            $data,
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText'
        );

        $data = [
            [
                'attributeId' => ProductModifier::PRODUCT_NAME,
                'value' => 'meta title',
                'store' => $shopId,
            ],
            [
                'attributeId' => ProductModifier::PRODUCT_URL_PATH,
                'value' => 'link',
                'store' => $shopId,
            ],
            [
                'attributeId' => ProductModifier::PRODUCT_IMAGE,
                'value' => 'image',
                'store' => $shopId,
            ],
            [
                'attributeId' => ProductModifier::PRODUCT_SMALL_IMAGE,
                'value' => 'thumb',
                'store' => $shopId,
            ],
            [
                'attributeId' => 3,
                'value' => 'nothing',
                'store' => $shopId,
            ],
            [
                'attributeId' => 3,
                'value' => 'nothing',
                'store' => $shopId + 1,
            ],
        ];

        $varcharAttributes = $this->getAttributesArray(
            $data,
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar'
        );

        $data = [
            [
                'attributeId' => 96,
                'value' => 1,
                'store' => $shopId + 1,
            ],
        ];

        $websiteId = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductWebsite');
        $websiteId->setId(1);
        $websiteId->setWebsiteId(0);
        $websiteIdArray[] = $websiteId;

        /** @var CatalogProductEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(ProductModifier::PRODUCT_NAME);
        $varchar->setValue('meta title');
        $varchar->setStore($shopId);
        $integerAttributes = $this->getAttributesArray(
            $data,
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityInt'
        );

        /** @var CatalogProductIndexPrice $price */
        $price = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductIndexPrice'
        );
        $price->setPrice(123.99);

        /** @var CatalogProductEntity $entity */
        $entity = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity'
        );

        /** @var CatalogCategoryProduct $categoryCross */
        $categoryCross = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryProduct'
        );

        /** @var CatalogCategoryEntity $category */
        $category = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity'
        );
        $category->setId(1);
        $category->setPath('1/2/3');

        /** @var CatalogProductEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar'
        );
        $varchar->setAttributeId(CategoryModifier::CATEGORY_NAME);
        $varchar->setValue('category title');
        $category->addVarcharAttribute($varchar);

        $varchar = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar'
        );
        $varchar->setAttributeId(CategoryModifier::CATEGORY_URL_PATH);
        $varchar->setValue('category link');
        $category->addVarcharAttribute($varchar);

        $varchar = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar'
        );
        $varchar->setAttributeId(3);
        $varchar->setValue('value');
        $category->addVarcharAttribute($varchar);

        $categoryCross->setCategory($category);

        $entity
            ->setId(123)
            ->setSku('foo')
            ->addPrice($price)
            ->setTextAttributes($textAttributes)
            ->setVarcharAttributes($varcharAttributes)
            ->addCategory($categoryCross)
            ->addWebsiteId($websiteId)
            ->setIntegerAttributes($integerAttributes);

        $categoryObject = new CategoryObject();
        $categoryObject->setId(1);
        $categoryObject->setPath('3');
        $categoryObject->setCategories(['3']);
        $categoryObject->setTitle('category title');

        $urlObject = new UrlObject();
        $urlObject->setUrl('category link');
        $categoryObject->setUrl($urlObject);

        $priceObject = new PriceObject(123.99);

        $expectedDocument = new ProductDocument();
        $expectedDocument->setId(123);
        $expectedDocument->addPrice($priceObject);
        $expectedDocument->setSku('foo');
        $expectedDocument->setShortDescription('short description');
        $expectedDocument->setDescription('description');
        $expectedDocument->setTitle('meta title');
        $expectedDocument->addImageUrl('image');
        $expectedDocument->addSmallImageUrl('thumb');
        $expectedDocument->addUrl('link');
        $expectedDocument->addCategory($categoryObject);
        $expectedDocument->setExpiredUrls([]);

        $document = new ProductDocument();
        $item = new ImportItem($entity, $document);

        $method = new \ReflectionMethod(
            'ONGR\MagentoConnectorBundle\Modifier\ProductModifier',
            'modify'
        );
        $method->setAccessible(true);
        $event = new ItemPipelineEvent($item);
        $method->invoke(new ProductModifier($store_id, $shopId), $item, $event);

        $this->assertEquals($expectedDocument, $document);
    }

    /**
     * Test for modify method.
     */
    public function testIsProductActive()
    {
        $data = [
            [
                'attributeId' => 3,
                'value' => 1,
                'store' => 1,
            ],
        ];

        $integerAttributes = $this->getAttributesArray(
            $data,
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityInt'
        );

        /** @var CatalogProductEntity $entity */
        $entity = $this->getMockForAbstractClass(
            'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity'
        );
        $entity->setIntegerAttributes($integerAttributes);

        $method = new \ReflectionMethod(
            'ONGR\MagentoConnectorBundle\Modifier\ProductModifier',
            'isProductActive'
        );
        $result = $method->invoke(new ProductModifier(1, 0), $entity);

        $this->assertTrue($result);
    }
}
