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
use ONGR\MagentoConnectorBundle\Document\UrlObject;

class CategoryDocumentTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        $urlObject = new UrlObject();
        $urlObject->setUrl('test');

        return [
            ['urls', 'ONGR\MagentoConnectorBundle\Document\UrlObject', 'addUrl'],
            ['urls', 'array', 'addUrlString'],
            ['urls', 'array', null, null, ['setUrlString' => ['test', [$urlObject]]]],
            ['expiredUrls', 'array', 'addExpiredUrl'],
            ['path'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Document\CategoryDocument';
    }
}
