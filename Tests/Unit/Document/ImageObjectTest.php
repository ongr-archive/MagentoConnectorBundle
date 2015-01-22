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

use ONGR\MagentoConnectorBundle\Document\ImageObject;

class ImageObjectTest extends AbstractGetterSetterTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->document = new ImageObject();
    }

    /**
     * {@inheritdoc}
     */
    public function attributesDataProvider()
    {
        return [
            [
                'setter' => 'setCdn',
                'getter' => 'getCdn',
                'expectedMethod' => 'getExpectedUrlsArray',
            ],
            [
                'setter' => 'setDescription',
                'getter' => 'getDescription',
                'expectedMethod' => 'getExpectedDescriptionArray',
            ],
            [
                'setter' => 'setTitle',
                'getter' => 'getTitle',
                'expectedMethod' => 'getExpectedTitleArray',
            ],
            [
                'setter' => 'setUrl',
                'getter' => 'getUrl',
                'expectedMethod' => 'getExpectedUrlsArray',
            ],
        ];
    }
}
