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

use ONGR\MagentoConnectorBundle\Document\CategoryObject;
use ONGR\MagentoConnectorBundle\Tests\app\fixtures\ExpectedDocuments\ExpectedDocuments;

class CategoryObjectTest extends AbstractGetterSetterTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->document = new CategoryObject();
    }

    /**
     * {@inheritdoc}
     */
    public function attributesDataProvider()
    {
        return [
            [
                'setter' => 'setId',
                'getter' => 'getId',
                'expectedMethod' => 'getExpectedIdArray',
            ],
            [
                'setter' => 'setTitle',
                'getter' => 'getTitle',
                'expectedMethod' => 'getExpectedTitleArray',
            ],
            [
                'setter' => 'setUrl',
                'getter' => 'getUrl',
                'expectedMethod' => 'getExpectedUrlsObjects',
            ],
            [
                'setter' => 'setCategories',
                'getter' => 'getCategories',
                'expectedMethod' => 'getExpectedCategoryObject',
                'addObject' => 'addCategory',
            ],
            [
                'setter' => 'setPath',
                'getter' => 'getPath',
                'expectedMethod' => 'getExpectedPathArray',
            ],
        ];
    }
}
