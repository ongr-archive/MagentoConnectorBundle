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

use ONGR\MagentoConnectorBundle\Document\UrlObject;

class UrlObjectTest extends AbstractGetterSetterTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->document = new UrlObject();
    }

    /**
     * {@inheritdoc}
     */
    public function attributesDataProvider()
    {
        return [
            [
                'setter' => 'setCdnUrl',
                'getter' => 'getCdnUrl',
                'expectedMethod' => 'getExpectedUrlsArray',
            ],
            [
                'setter' => 'setUrl',
                'getter' => 'getUrl',
                'expectedMethod' => 'getExpectedUrlsArray',
            ],
            [
                'setter' => 'setUrlKey',
                'getter' => 'getUrlKey',
                'expectedMethod' => 'getExpectedUrlsArray',
            ],
        ];
    }
}
