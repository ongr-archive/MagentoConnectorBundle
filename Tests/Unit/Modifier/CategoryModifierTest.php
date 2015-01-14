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
use ONGR\MagentoConnectorBundle\Document\CategoryDocument;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier;

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
        $varchar->setAttributeId(CategoryModifier::CATEGORY_NAME);
        $varchar->setValue('title');
        $varchar->setStore($shopId);
        $varcharAttributes = [$varchar];

        /** @var CatalogCategoryEntityVarchar $varchar */
        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar');
        $varchar->setAttributeId(CategoryModifier::CATEGORY_URL_PATH);
        $varchar->setValue('url');
        $varchar->setStore($shopId);
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(3);
        $varchar->setStore($shopId);
        $varchar->setValue('nothing');
        $varcharAttributes[] = $varchar;

        $varchar = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar');
        $varchar->setAttributeId(3);
        $varchar->setStore($shopId + 1);
        $varchar->setValue('nothing');
        $varcharAttributes[] = $varchar;

        /** @var CatalogCategoryEntityInt $integer */
        $integer = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt');
        $integer->setAttributeId(3);
        $integer->setValue(0);
        $integer->setStore($shopId + 1);
        $integerAttributes = [$integer];

        /** @var CatalogCategoryEntityInt $integer1 */
        $integer1 = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt');
        $integer1->setAttributeId(CategoryModifier::CATEGORY_IS_ACTIVE);
        $integer1->setValue(1);
        $integer1->setStore($shopId);

        /** @var CatalogCategoryEntityInt $integer2 */
        $integer2 = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt');
        $integer2->setAttributeId(3);
        $integer2->setValue(0);
        $integer2->setStore($shopId);

        /** @var CatalogCategoryEntity $entity */
        $entity = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity');
        $entity->setVarcharAttributes($varcharAttributes)
            ->setIntegerAttributes($integerAttributes)
            ->addIntegerAttribute($integer1)
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
        $expectedDocument->setExpiredUrls([]);

        $modifier = new CategoryModifier($shopId);

        $document = new CategoryDocument();
        $item = new ImportItem($entity, $document);
        $event = new ItemPipelineEvent($item);
        $modifier->onModify($event);
        $this->assertEquals($expectedDocument, $document);

        $entity
            ->setPath('1/2')
            ->setLevel(2);
        $expectedDocument->setPath('');
        $expectedDocument->setParentId(CategoryDocument::ROOT_ID);
        $item = new ImportItem($entity, $document);
        $event = new ItemPipelineEvent($item);
        $modifier->onModify($event);
        $this->assertEquals($expectedDocument, $document);

        $entity
            ->setPath('1')
            ->setLevel(1);
        $this->setExpectedException('Exception');
        $item = new ImportItem($entity, $document);
        $event = new ItemPipelineEvent($item);
        $modifier->onModify($event);
    }
}
