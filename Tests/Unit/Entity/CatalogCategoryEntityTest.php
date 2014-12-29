<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            [
                'products',
                'ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity',
                'addProduct',
                'removeProduct',
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
