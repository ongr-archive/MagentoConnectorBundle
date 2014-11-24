<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Entity;

use ONGR\ConnectionsBundle\Tests\Unit\Entity\AbstractEntityTest;

class CatalogCategoryEntityTest extends AbstractEntityTest
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
            ['parentId'],
            ['sort'],
            ['path'],
            ['level'],
            [
                'integerAttributes',
                'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt',
                'addIntegerAttribute',
                'removeIntegerAttribute',
            ],
            [
                'varcharAttributes',
                'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar',
                'addVarcharAttribute',
                'removeVarcharAttribute',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity';
    }
}
