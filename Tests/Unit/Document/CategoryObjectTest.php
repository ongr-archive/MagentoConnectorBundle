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

class CategoryObjectTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        $urlObject = new UrlObject();
        $urlObject->setUrl('test');

        return [
            ['id'],
            ['title'],
            ['url', 'string', null, null, ['setUrlString' => ['test', $urlObject]]],
            ['path'],
            ['categories', 'array', 'addCategory'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Document\CategoryObject';
    }
}
