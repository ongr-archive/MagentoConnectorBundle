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

class ContentDocumentTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        return [
            ['heading'],
            ['urls', 'ONGR\MagentoConnectorBundle\Document\UrlObject', 'addUrl'],
            ['urls', 'array', 'addUrlString'],
            ['expiredUrls', 'array', 'addExpiredUrl'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Document\ContentDocument';
    }
}
