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
                'websiteIds',
                'ONGR\MagentoConnectorBundle\Entity\CatalogProductWebsite',
                'addWebsiteId',
                'removeWebsiteId',
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
