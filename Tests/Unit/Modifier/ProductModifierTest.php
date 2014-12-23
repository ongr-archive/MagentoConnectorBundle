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

use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\MagentoConnectorBundle\Documents\CategoryObject;
use ONGR\MagentoConnectorBundle\Documents\PriceObject;
use ONGR\MagentoConnectorBundle\Documents\UrlObject;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryProduct;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductIndexPrice;
use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier;
use ONGR\MagentoConnectorBundle\Modifier\ProductModifier;
use ONGR\MagentoConnectorBundle\Documents\ProductDocument;

class ProductModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $shopId = 1;

        /** @var CatalogProductIndexPrice $price */
        $price = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductIndexPrice');
        $price->setPrice(123.99);

        /** @var CatalogProductEntityText $text */
        $text = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText');
        $text->setAttributeId(ProductModifier::PRODUCT_DESCRIPTION);
        $text->setValue('long description');
        $text->setStore($shopId);
        $textAttributes = [ $text ];

        $text = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText');
        $text->setAttributeId(ProductModifier::PRODUCT_SHORT_DESCRIPTION);
        $text->setValue('description');
        $text->setStore($shopId);
        $textAttributes[] = $text;

        $text = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText');
        $text->setAttributeId(3);
        $text->setValue('nothing');
        $text->setStore($shopId);
        $textAttributes[] = $text;

        $text = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText');
        $text->setAttributeId(3);
        $text->setValue('nothing');
        $text->setStore($shopId + 1);
        $textAttributes[] = $text;

        /** @var CatalogProductEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(ProductModifier::PRODUCT_META_TITLE);
        $varchar->setValue('meta title');
        $varchar->setStore($shopId);
        $varcharAttributes = [ $varchar ];

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(ProductModifier::PRODUCT_LINKS_TITLE);
        $varchar->setValue('link');
        $varchar->setStore($shopId);
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(ProductModifier::PRODUCT_IMAGE);
        $varchar->setValue('image');
        $varchar->setStore($shopId);
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(ProductModifier::PRODUCT_SMALL_IMAGE);
        $varchar->setValue('thumb');
        $varchar->setStore($shopId);
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(3);
        $varchar->setValue('nothing');
        $varchar->setStore($shopId);
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(3);
        $varchar->setValue('nothing');
        $varchar->setStore($shopId + 1);
        $varcharAttributes[] = $varchar;

        /** @var CatalogProductEntity $entity */
        $entity = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity');

        /** @var CatalogCategoryProduct $categoryCross */
        $categoryCross = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryProduct');

        /** @var CatalogCategoryEntity $category */
        $category = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity');
        $category->setId(1);
        $category->setPath('1/2/3');

        /** @var CatalogProductEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(CategoryModifier::CATEGORY_TITLE);
        $varchar->setValue('category title');
        $category->addVarcharAttribute($varchar);

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(CategoryModifier::CATEGORY_LINKS_TITLE);
        $varchar->setValue('category link');
        $category->addVarcharAttribute($varchar);

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
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
            ->addCategory($categoryCross);

        $categoryObject = new CategoryObject();
        $categoryObject->setId(1);
        $categoryObject->setPath('3');
        $categoryObject->setCategories(['3']);
        $categoryObject->setTitle('category title');

        $urlObject = new UrlObject();
        $urlObject->setUrl('category link');
        $categoryObject->setUrl($urlObject);

        $priceObject = new PriceObject();
        $priceObject->setPrice(123.99);

        $expectedDocument = new ProductDocument();
        $expectedDocument->setId(123);
        $expectedDocument->addPrice($priceObject);
        $expectedDocument->setSku('foo');
        $expectedDocument->setLongDescription('long description');
        $expectedDocument->setDescription('description');
        $expectedDocument->setTitle('meta title');
        $expectedDocument->addImageUrl('image');
        $expectedDocument->addSmallImageUrl('thumb');
        $expectedDocument->addUrl('link');
        $expectedDocument->addCategory($categoryObject);
        $expectedDocument->setExpiredUrl([]);

        $document = new ProductDocument();
        $item = new ImportItem($entity, $document);

        $method = new \ReflectionMethod(
            'ONGR\MagentoConnectorBundle\Modifier\ProductModifier',
            'modify'
        );
        $method->setAccessible(true);
        $method->invoke(new ProductModifier($shopId), $item);

        $this->assertEquals($expectedDocument, $document);
    }
}
