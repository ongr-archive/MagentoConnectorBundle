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

use ONGR\MagentoConnectorBundle\Document\ContentDocument;
use ONGR\MagentoConnectorBundle\Tests\app\fixtures\ExpectedDocuments\ExpectedDocuments;

class ContentDocumentTest extends AbstractGetterSetterTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->document = new ContentDocument();
    }

    /**
     * {@inheritdoc}
     */
    public function attributesDataProvider()
    {
        return [
            [
                'setter' => 'setExpiredUrls',
                'getter' => 'getExpiredUrls',
                'expectedMethod' => 'getExpectedUrlsArray',
                'addObject' => 'addExpiredUrl',
            ],
            [
                'setter' => 'setUrls',
                'getter' => 'getUrls',
                'expectedMethod' => 'getExpectedUrlsObjects',
                'addObject' => 'addUrl',
                'stringSetter' => 'addUrlString',
                'stringForSetter' => ExpectedDocuments::getCategoryDocument()[2]['urls'][0]['url'],
            ],
            [
                'setter' => 'setHeading',
                'getter' => 'getHeading',
                'expectedMethod' => 'getExpectedDescriptionArray',
            ],
        ];
    }
}
