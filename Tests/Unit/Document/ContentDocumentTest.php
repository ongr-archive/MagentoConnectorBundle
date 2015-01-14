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
use ONGR\MagentoConnectorBundle\Document\ContentDocument;

class ContentDocumentTest extends AbstractEntityTest
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
            ['heading'],
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
            'slug',
            'title',
            'content',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Document\ContentDocument';
    }

    /**
     * Test Add and Remove methods.
     */
    public function testAddRemoveMethods()
    {
        $testUrl = 'test-url';
        $categoryDocument = new ContentDocument();
        $categoryDocument->addExpiredUrl($testUrl);
        $this->assertEquals([$testUrl], $categoryDocument->getExpiredUrls());

        $categoryDocument->removeExpiredUrl($testUrl);
        $this->assertEquals(0, count($categoryDocument->getExpiredUrls()));
    }
}
