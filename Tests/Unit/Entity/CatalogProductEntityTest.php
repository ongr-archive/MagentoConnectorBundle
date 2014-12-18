<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Entity;

use ONGR\ConnectionsBundle\Tests\Unit\Entity\AbstractEntityTest;

class CatalogProductEntityTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        return [
            ['id'],
            ['createdAt'],
            ['updatedAt'],
            [
                'prices',
                'ONGR\MagentoConnectorBundle\Entity\CatalogProductIndexPrice',
                'addPrice',
                'removePrice',
            ],
            [
                'integerAttributes',
                'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityInt',
                'addIntegerAttribute',
                'removeIntegerAttribute',
            ],
            [
                'textAttributes',
                'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText',
                'addTextAttribute',
                'removeTextAttribute',
            ],
            ['sku'],
            [
                'varcharAttributes',
                'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar',
                'addVarcharAttribute',
                'removeVarcharAttribute',
            ],
            [
                'categories',
                'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity',
                'addCategory',
                'removeCategory',
            ],
            ['attributeSetId'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity';
    }
}
