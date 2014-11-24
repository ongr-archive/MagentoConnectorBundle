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
            ['price'],
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
            ['category'],
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
