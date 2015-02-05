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
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier;
use ONGR\MagentoConnectorBundle\Tests\Unit\Modifier\Helper\ModifierHelperTrait;

class CategoryModifierTest extends \PHPUnit_Framework_TestCase
{
    use ModifierHelperTrait;

    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $shopId = 1;

        /** @var CatalogCategoryEntityVarchar $varchar */
        $data = [
            [
                'attributeId' => CategoryModifier::CATEGORY_NAME,
                'value' => 'title',
                'store' => $shopId,
            ],
            [
                'attributeId' => CategoryModifier::CATEGORY_URL_PATH,
                'value' => 'url',
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
            'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar'
        );

        $data = [
            [
                'attributeId' => 3,
                'value' => 0,
                'store' => $shopId + 1,
            ],
            [
                'attributeId' => CategoryModifier::CATEGORY_IS_ACTIVE,
                'value' => 1,
                'store' => $shopId,
            ],
            [
                'attributeId' => 3,
                'value' => 0,
                'store' => $shopId,
            ],
        ];

        $integerAttributes = $this->getAttributesArray(
            $data,
            'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt'
        );

        /** @var CatalogCategoryEntity $entity */
        $entity = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity');
        $entity->setVarcharAttributes($varcharAttributes)
            ->setIntegerAttributes($integerAttributes)
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

        $method = new \ReflectionMethod(
            'ONGR\MagentoConnectorBundle\Modifier\CategoryModifier',
            'modify'
        );
        $method->setAccessible(true);
        $modifier = new CategoryModifier($shopId);

        $document = new CategoryDocument();
        $item = new ImportItem($entity, $document);
        $event = new ItemPipelineEvent($item);
        $method->invoke($modifier, $item, $event);
        $this->assertEquals($expectedDocument, $document);

        $entity
            ->setPath('1/2')
            ->setLevel(2);
        $expectedDocument->setPath('');
        $expectedDocument->setParentId(CategoryDocument::ROOT_ID);
        $item = new ImportItem($entity, $document);
        $event = new ItemPipelineEvent($item);
        $method->invoke($modifier, $item, $event);
        $this->assertEquals($expectedDocument, $document);
    }
}
