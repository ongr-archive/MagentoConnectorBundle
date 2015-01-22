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

use ONGR\MagentoConnectorBundle\Document\ProductDocument;
use ONGR\MagentoConnectorBundle\Tests\app\fixtures\ExpectedDocuments\ExpectedDocuments;

class ProductDocumentTest extends AbstractGetterSetterTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->document = new ProductDocument();
    }

    /**
     * {@inheritdoc}
     */
    public function attributesDataProvider()
    {
        return [
            [
                'setter' => 'setPrices',
                'getter' => 'getPrices',
                'expectedMethod' => 'getExpectedPriceObject',
                'addObject' => 'addPrice',
            ],
            [
                'setter' => 'setImages',
                'getter' => 'getImages',
                'expectedMethod' => 'getExpectedImageObject',
                'addObject' => 'addImage',
            ],
            [
                'setter' => 'setCategories',
                'getter' => 'getCategories',
                'expectedMethod' => 'getExpectedCategoryObject',
                'addObject' => 'addCategory',
            ],
            [
                'setter' => 'setSmallImages',
                'getter' => 'getSmallImages',
                'expectedMethod' => 'getExpectedImageObject',
                'addObject' => 'addSmallImage',
                'stringSetter' => 'addSmallImageUrl',
                'stringForSetter' => ExpectedDocuments::getProductDocument()[2]['images'][0]['url'],
            ],
            [
                'setter' => 'setUrls',
                'getter' => 'getUrls',
                'expectedMethod' => 'getExpectedUrlsObjects',
                'addObject' => 'addUrlObject',
                'stringSetter' => 'addUrl',
                'stringForSetter' => ExpectedDocuments::getCategoryDocument()[2]['urls'][0]['url'],
            ],
            [
                'setter' => 'setExpiredUrls',
                'getter' => 'getExpiredUrls',
                'expectedMethod' => 'getExpectedUrlsArray',
                'addObject' => 'addExpiredUrl',
            ],
            [
                'setter' => 'setShortDescription',
                'getter' => 'getShortDescription',
                'expectedMethod' => 'getExpectedDescriptionArray',
            ],
        ];
    }
}
