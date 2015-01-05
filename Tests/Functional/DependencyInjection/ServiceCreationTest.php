<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\MagentoConnectorBundle\Tests\Functional\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * This class contains tests to find out if services are defined correctly.
 */

class ServiceCreationTest extends WebTestCase
{
    /**
     * Tests if services are defined correctly.
     *
     * @param string $service
     * @param string $instance
     *
     * @dataProvider getTestServiceCreationData()
     */
    public function testServiceCreation($service, $instance)
    {
        $container = self::createClient()->getContainer();

        $this->assertTrue($container->has($service));
        $this->assertInstanceOf($instance, $container->get($service));
    }

    /**
     * Data provider for testServiceCreation().
     *
     * @return array[]
     */
    public function getTestServiceCreationData()
    {
        $out = [];

        // Case #0: Product modifier.
        $out[] = ['ongr_magento.modifier.product', 'ONGR\MagentoConnectorBundle\Modifier\ProductModifier'];

        // Case #1: Category modifier.
        $out[] = ['ongr_magento.modifier.category', 'ONGR\MagentoConnectorBundle\Modifier\CategoryModifier'];

        // Case #2: Content modifier.
        $out[] = ['ongr_magento.modifier.content', 'ONGR\MagentoConnectorBundle\Modifier\ContentModifier'];

        return $out;
    }
}
