<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\MagentoConnectorBundle\Tests\Functional\Modifier;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\MagentoConnectorBundle\Document\CategoryDocument;
use ONGR\MagentoConnectorBundle\Document\UrlObject;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier;
use ONGR\MagentoConnectorBundle\Tests\Functional\Entity\CatalogCategoryEntity as CategoryEntity;
use ONGR\MagentoConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if category modifier works as expected.
 */
class CategoryModifierTest extends TestBase
{
    const ATTRIBUTE_TYPE_INT = 1;
    const ATTRIBUTE_TYPE_VARCHAR = 2;

    /**
     * Attributes test data provider.
     *
     * @return array
     */
    public function attributesDataProvider()
    {
        return [
            [
                'categoryId' => 4,
                'type' => self::ATTRIBUTE_TYPE_INT,
                'data' => [
                    [13, 42, 1],
                    [14, 67, 1],
                    [15, 50, 27],
                    [16, 51, 1],
                    [17, 68, 0],
                    [18, 69, 0],
                ],
            ],
            [
                'categoryId' => 4,
                'type' => self::ATTRIBUTE_TYPE_VARCHAR,
                'data' => [
                    [16, 41, 'Women'],
                    [17, 43, 'women'],
                    [18, 46, null],
                    [19, 49, 'PAGE'],
                    [20, 58, null],
                    [21, 61, 'one_column'],
                    [22, 57, 'women.html'],
                    [23, 57, 'women.html'],
                    [428, 45, null],
                ],
            ],
        ];
    }

    /**
     * Test Int and Varchar attributes.
     *
     * @param int   $categoryId
     * @param int   $attributeType
     * @param array $expectedAttributes
     *
     * @dataProvider attributesDataProvider
     */
    public function testAttributes($categoryId, $attributeType, $expectedAttributes)
    {
        if (!in_array($attributeType, [self::ATTRIBUTE_TYPE_INT, self::ATTRIBUTE_TYPE_VARCHAR])) {
            return;
        }

        /** @var CategoryEntity $categoryItem */
        $categoryItem = $this->getTestElements(
            [$categoryId],
            'ONGRMagentoConnectorBundleTest:CatalogCategoryEntity'
        )[0];

        if ($attributeType == self::ATTRIBUTE_TYPE_INT) {
            /** @var CatalogCategoryEntityInt[] $categoryAttributes */
            $categoryAttributes = $categoryItem->getIntegerAttributes();
        } else {
            /** @var CatalogCategoryEntityVarchar[] $categoryAttributes */
            $categoryAttributes = $categoryItem->getVarcharAttributes();
        }

        $categoryAttributeValues = [];

        foreach ($categoryAttributes as $categoryAttribute) {
            $categoryAttributeValues[] = [
                $categoryAttribute->getId(),
                $categoryAttribute->getAttributeId(),
                $categoryAttribute->getValue(),
            ];
        }

        $this->assertEquals($expectedAttributes, $categoryAttributeValues);
    }

    /**
     * Test modification.
     */
    public function testModify()
    {
        $shopId = 0;

        $expectedEntity1 = new CategoryDocument();
        $expectedEntity1->setId(4);
        $expectedEntity1->setPath('/4');
        $expectedEntity1->setActive(true);
        $expectedEntity1->setHidden(false);
        $expectedEntity1->setLeft(null);
        $expectedEntity1->setRight(null);
        $expectedEntity1->setParentId(2);
        $expectedEntity1->setSort(2);
        $expectedEntity1->setTitle('Women');

        $url = new UrlObject();
        $url->setUrl('women.html');
        $expectedEntity1->addUrl($url);

        $expectedEntity2 = new CategoryDocument();
        $expectedEntity2->setPath('/5');
        $expectedEntity2->setId(5);
        $expectedEntity2->setActive(true);
        $expectedEntity2->setHidden(false);
        $expectedEntity2->setLeft(null);
        $expectedEntity2->setRight(null);
        $expectedEntity2->setParentId(2);
        $expectedEntity2->setSort(3);
        $expectedEntity2->setTitle('Men');
        $expectedEntity2->addUrlString('men.html');

        $expectedEntities = [$expectedEntity1, $expectedEntity2];

        /** @var CategoryEntity[] $categoryItems */
        $categoryItems = $this->getTestElements(
            ['4', '5'],
            'ONGRMagentoConnectorBundleTest:CatalogCategoryEntity'
        );
        $this->assertCount(2, $categoryItems);

        $modifier = new CategoryModifier($shopId);
        $createdCategories = [];

        foreach ($categoryItems as $categoryItem) {
            $createdCategory = new CategoryDocument($shopId);
            $item = new ImportItem($categoryItem, $createdCategory);
            $event = new ItemPipelineEvent($item);
            $modifier->onModify($event);
            $createdCategories[] = $createdCategory;
        }

        $this->assertEquals($expectedEntities, $createdCategories);
    }
}
