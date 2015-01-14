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

class PriceObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Price object.
     */
    public function testPriceObject()
    {
        $price = 15.48;
        $priceObject = new PriceObject($price);
        $this->assertEquals($price, $priceObject->getPrice());
    }
}
