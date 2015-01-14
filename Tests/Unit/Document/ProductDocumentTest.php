<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Document;

use ONGR\ConnectionsBundle\Tests\Unit\Entity\AbstractEntityTest;
use ONGR\MagentoConnectorBundle\Document\ProductDocument;

class ProductDocumentTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        return [
            [
                'urls',
                'ONGR\MagentoConnectorBundle\Document\UrlObject',
                'addUrl',
                'removeUrl',
            ],
            ['expiredUrls'],
            ['images'],
            ['smallImages'],
            [
                'categories',
                'ONGR\MagentoConnectorBundle\Document\CategoryObject',
                'addCategory',
                'removeCategory',
            ],
            ['prices'],
            ['shortDescription'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getIgnoredFields()
    {
        return [
            'id',
            'score',
            'parent',
            'ttl',
            'highlight',
            'title',
            'description',
            'longDescription',
            'sku',
            'price',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Document\ProductDocument';
    }

    /**
     * Test Add and Remove methods.
     */
    public function testAddRemoveMethods()
    {
        $testUrl = 'test-url';
        $productDocument = new ProductDocument();
        $productDocument->addExpiredUrl($testUrl);
        $this->assertEquals([$testUrl], $productDocument->getExpiredUrls());

        $productDocument->removeExpiredUrl($testUrl);
        $this->assertEquals(0, count($productDocument->getExpiredUrls()));
    }
}
