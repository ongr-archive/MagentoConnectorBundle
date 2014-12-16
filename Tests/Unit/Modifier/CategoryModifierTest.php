<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier;

use ONGR\ConnectionsBundle\Event\ImportItem;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier;
use ONGR\MagentoConnectorBundle\Modifier\Helpers\AttributeTypes;
use ONGR\MagentoConnectorBundle\Documents\CategoryDocument;

class CategoryModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $shopId = 1;

        /** @var CatalogCategoryEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::CATEGORY_TITLE);
        $varchar->setValue('title');
        $varchar->setStore($shopId);
        $varcharAttributes = [ $varchar ];

        /** @var CatalogCategoryEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar');
        $varchar->setAttributeId(AttributeTypes::CATEGORY_LINKS_TITLE);
        $varchar->setValue('url');
        $varchar->setStore($shopId);
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(3);
        $varchar->setStore($shopId);
        $varchar->setValue('nothing');

        /** @var CatalogCategoryEntityInt $integer */
        $integer = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt');
        $integer->setAttributeId(AttributeTypes::CATEGORY_IS_ACTIVE);
        $integer->setValue(1);
        $integer->setStore($shopId);

        /** @var CatalogCategoryEntityInt $integer2 */
        $integer2 = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt');
        $integer2->setAttributeId(3);
        $integer2->setValue(0);
        $integer->setStore($shopId);

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

        $expectedDocument = new CategoryDocument();
        $expectedDocument->setId(2);
        $expectedDocument->setPath('/3');
        $expectedDocument->setParentId(1);
        $expectedDocument->setSort(3);
        $expectedDocument->setTitle('title');
        $expectedDocument->setActive(true);
        $expectedDocument->addUrlString('url');
        $expectedDocument->setExpiredUrl([]);

        $method = new \ReflectionMethod(
            'ONGR\MagentoConnectorBundle\Modifier\CategoryModifier',
            'modify'
        );
        $method->setAccessible(true);
        $modifier = new CategoryModifier($shopId);

        $document = new CategoryDocument();
        $item = new ImportItem($entity, $document);
        $method->invoke($modifier, $item);
        $this->assertEquals($expectedDocument, $document);

        $entity
            ->setPath('1/2')
            ->setLevel(2);
        $expectedDocument->setPath('');
        $expectedDocument->setParentId('oxrootid');
        $item = new ImportItem($entity, $document);
        $method->invoke($modifier, $item);
        $this->assertEquals($expectedDocument, $document);

        $entity
            ->setPath('1')
            ->setLevel(1);
        $this->setExpectedException('Exception');
        $item = new ImportItem($entity, $document);
        $method->invoke($modifier, $item);
    }
}
