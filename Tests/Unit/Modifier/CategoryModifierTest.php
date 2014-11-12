<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier;

use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier;
use ONGR\MagentoConnectorBundle\Modifier\Helpers\AttributeTypes;

class CategoryModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $modifier = new CategoryModifier(1);

        /** @var CatalogCategoryEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::CATEGORY_TITLE);
        $varchar->setValue('title');
        $varchar->setStore(1);
        $varcharAttributes = [ $varchar ];

        /** @var CatalogCategoryEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::CATEGORY_LINKS_TITLE);
        $varchar->setValue('url');
        $varchar->setStore(1);
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(3);
        $varchar->setStore(1);
        $varchar->setValue('nothing');

        /** @var CatalogCategoryEntityInt $integer */
        $integer = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt');
        $integer->setAttributeId(AttributeTypes::CATEGORY_IS_ACTIVE);
        $integer->setValue(1);
        $integer->setStore(1);

        /** @var CatalogCategoryEntityInt $integer2 */
        $integer2 = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt');
        $integer2->setAttributeId(3);
        $integer2->setValue(0);
        $integer->setStore(1);

        /** @var CatalogCategoryEntity $entity */
        $entity = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity');
        $entity->setVarcharAttributes($varcharAttributes)
            ->addIntegerAttribute($integer)
            ->addIntegerAttribute($integer2)
            ->setId(2)
            ->setParentId(1)
            ->setLevel(3)
            ->setPath('1/2/3')
            ->setSort(3);

        $expectedDocument = new CategoryModel();
        $expectedDocument->id = 2;
        $expectedDocument->path = '/3';
        $expectedDocument->parentid = 1;
        $expectedDocument->sort = 3;
        $expectedDocument->title = 'title';
        $expectedDocument->active = 'true';
        $expectedDocument->url = ['url'];
        $expectedDocument->expired_url = [];

        $document = new CategoryModel();
        $modifier->modify($document, $entity);

        $this->assertEquals($expectedDocument, $document);
    }
}
