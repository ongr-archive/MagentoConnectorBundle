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

use ONGR\MagentoConnectorBundle\Document\PriceObject;

class PriceObjectTest extends AbstractGetterSetterTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->document = new PriceObject(0.0);
    }

    /**
     * {@inheritdoc}
     */
    public function attributesDataProvider()
    {
        return [
            [
                'setter' => 'setPrice',
                'getter' => 'getPrice',
                'expectedMethod' => 'getExpectedPriceObject',
            ],
        ];
    }
}
