<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Magento;

use ONGR\MagentoConnectorBundle\Magento\AbstractMagentoSync;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Tests AbstractMagentoSyncTest.
 */
class AbstractMagentoSyncTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests setters and getters.
     */
    public function testSettersGetters()
    {
        /** @var AbstractMagentoSync|\PHPUnit_Framework_MockObject_MockObject $instance */
        $instance = $this->getMockBuilder('ONGR\MagentoConnectorBundle\Magento\AbstractMagentoSync')
            ->setMethods(null)
            ->getMockForAbstractClass();

        $this->assertNull($instance->getMagentoUrl());
        $this->assertNull($instance->getRequestStack());

        $url = 'testing-url';
        $instance->setMagentoUrl($url);
        $this->assertEquals($url, $instance->getMagentoUrl());

        /** @var RequestStack|\PHPUnit_Framework_MockObject_MockObject $requestStack */
        $requestStack = $this->getMockBuilder('Symfony\Component\HttpFoundation\RequestStack')
            ->disableOriginalConstructor()
            ->getMock();
        $instance->setRequestStack($requestStack);
        $this->assertSame($requestStack, $instance->getRequestStack());
    }
}
