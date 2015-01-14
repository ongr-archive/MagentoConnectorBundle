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
use ONGR\MagentoConnectorBundle\Document\CategoryDocument;

class CategoryDocumentTest extends AbstractEntityTest
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
            ['path'],
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
            'sort',
            'active',
            'parentId',
            'level',
            'title',
            'hidden',
            'left',
            'right',
            'expanded',
            'current',
            'breadcrumbs',
            'children',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Document\CategoryDocument';
    }

    /**
     * Test Add and Remove methods.
     */
    public function testAddRemoveMethods()
    {
        $testUrl = 'test-url';
        $categoryDocument = new CategoryDocument();
        $categoryDocument->addExpiredUrl($testUrl);
        $this->assertEquals([$testUrl], $categoryDocument->getExpiredUrls());

        $categoryDocument->removeExpiredUrl($testUrl);
        $this->assertEquals(0, count($categoryDocument->getExpiredUrls()));
    }
}
