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
use ONGR\MagentoConnectorBundle\Document\ImageObject;

class ProductDocumentTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        $imageObject = new ImageObject();
        $imageObject->setUrl('test');

        return [
            ['urls', 'ONGR\MagentoConnectorBundle\Document\UrlObject', 'addUrlObject'],
            ['urls', 'array', 'addUrl'],
            ['expiredUrls', 'array', 'addExpiredUrl'],
            ['images', 'ONGR\MagentoConnectorBundle\Document\ImageObject', 'addImage'],
            ['images', 'array', null, null, ['addImageUrl' => ['test', [$imageObject]]]],
            ['smallImages', 'ONGR\MagentoConnectorBundle\Document\ImageObject', 'addSmallImage'],
            ['smallImages', 'array', null, null, ['addSmallImageUrl' => ['test', [$imageObject]]]],
            ['categories', 'array', 'addCategory'],
            ['prices', 'array', 'addPrice'],
            ['shortDescription'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Document\ProductDocument';
    }
}
