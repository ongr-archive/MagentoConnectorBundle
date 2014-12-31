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

class CmsPageTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        return [
            ['id'],
            ['creationTime'],
            ['updateTime'],
            ['title'],
            ['slug'],
            ['content'],
            ['heading'],
            [
                'stores',
                'ONGR\MagentoConnectorBundle\Entity\CmsPage',
                'addStore',
                'removeStore',
            ],
            ['active'],
            ['metaDescription'],
            ['metaKeywords'],
            ['sortOrder'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Entity\CmsPage';
    }
}
