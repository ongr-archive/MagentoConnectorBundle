<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier;

use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryProduct;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductIndexPrice;
use ONGR\MagentoConnectorBundle\Modifier\Helpers\AttributeTypes;
use ONGR\MagentoConnectorBundle\Modifier\ProductModifier;
use ONGR\MagentoConnectorBundle\Tests\Helpers\ProductDocument;

class ProductModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $modifier = new ProductModifier(1);

        /** @var CatalogProductIndexPrice $price */
        $price = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductIndexPrice');
        $price->setPrice(123.99);

        /** @var CatalogProductEntityText $text */
        $text = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText');
        $text->setAttributeId(AttributeTypes::PRODUCT_DESCRIPTION);
        $text->setValue('long description');
        $text->setStore(1);

        $textAttributes = [ $text ];

        $text = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText');
        $text->setAttributeId(AttributeTypes::PRODUCT_SHORT_DESCRIPTION);
        $text->setValue('description');
        $text->setStore(1);

        $textAttributes[] = $text;

        $text = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText');
        $text->setAttributeId(3);
        $text->setValue('nothing');
        $text->setStore(1);

        $textAttributes[] = $text;

        /** @var CatalogProductEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::PRODUCT_META_TITLE);
        $varchar->setValue('meta title');
        $varchar->setStore(1);

        $varcharAttributes = [ $varchar ];

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::PRODUCT_LINKS_TITLE);
        $varchar->setValue('link');
        $varchar->setStore(1);

        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::PRODUCT_IMAGE);
        $varchar->setValue('image');
        $varchar->setStore(1);

        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::PRODUCT_SMALL_IMAGE);
        $varchar->setValue('thumb');
        $varchar->setStore(1);

        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(3);
        $varchar->setValue('nothing');
        $varchar->setStore(1);

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
        $varchar->setAttributeId(AttributeTypes::CATEGORY_TITLE);
        $varchar->setValue('category title');

        $category->addVarcharAttribute($varchar);
        $categoryCross->setCategory($category);

        $entity
            ->setId(123)
            ->setSku('foo')
            ->setPrice($price)
            ->setTextAttributes($textAttributes)
            ->setVarcharAttributes($varcharAttributes)
            ->setCategory($categoryCross);

        $expectedDocument = new ProductDocument();
        $expectedDocument->id = 123;
        $expectedDocument->price = 123.99;
        $expectedDocument->sku = 'foo';
        $expectedDocument->longDescription = 'long description';
        $expectedDocument->description = 'description';
        $expectedDocument->title = 'meta title';
        $expectedDocument->image = 'image';
        $expectedDocument->thumb = 'thumb';
        $expectedDocument->url = ['link'];
        $expectedDocument->category = [3];
        $expectedDocument->mainCategory = 1;
        $expectedDocument->category_id = [3];
        $expectedDocument->category_title = ['category title'];
        $expectedDocument->expired_url = [];
        $expectedDocument->origin = new \stdClass;
        $expectedDocument->origin->country = '';
        $expectedDocument->origin->location = '';
        $expectedDocument->location = new \stdClass;
        $expectedDocument->location->lon = 0;
        $expectedDocument->location->lat = 0;

        $document = new ProductDocument();
        $modifier->modify($document, $entity);

        $this->assertEquals($expectedDocument, $document);
    }
}
