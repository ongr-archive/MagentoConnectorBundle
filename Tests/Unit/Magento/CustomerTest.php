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

use ONGR\MagentoConnectorBundle\Magento\Cart;
use ONGR\MagentoConnectorBundle\Magento\Customer;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Tests Customer class.
 */
class CustomerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Customer class.
     */
    public function testCustomer()
    {
        $instance = new Customer();
        $instance->setMagentoUrl('testing.url');

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request->expects($this->any())->method('getUri')->willReturn('testing.uri');

        /** @var RequestStack|\PHPUnit_Framework_MockObject_MockObject $requestStack */
        $requestStack = $this->getMockBuilder('Symfony\Component\HttpFoundation\RequestStack')
            ->disableOriginalConstructor()
            ->getMock();
        $requestStack->expects($this->any())->method('getMasterRequest')->willReturn($request);
        $instance->setRequestStack($requestStack);

        $this->assertEquals(
            'testing.url' . Customer::LOGIN_PATH . '?' . Cart::MAGENTO_RETURN_URL_PARAM_NAME . '=testing.uri',
            $instance->getLoginUrl()
        );

        $this->assertEquals(
            'testing.url' . Customer::LOGOUT_PATH . '?' . Cart::MAGENTO_RETURN_URL_PARAM_NAME . '=testing.uri',
            $instance->getLogoutUrl()
        );

        $data = new ParameterBag();
        $instance->setUserData($data);
        $this->assertSame($data, $instance->getUserData());
    }

    /**
     * Data provider for testGetUserData.
     *
     * @return array
     */
    public function cookieProvider()
    {
        return [
            // Case #0.
            [[Customer::USER_DATA_COOKIE_NAME => '{"dummy":"data"}'], new ParameterBag([ 'dummy' => 'data'])],
            // Case #1.
            [[Customer::USER_DATA_COOKIE_NAME => '[]'], new ParameterBag()],
            // Case #1.
            [[Customer::USER_DATA_COOKIE_NAME => '{}'], new ParameterBag()],
            // Case #2.
            [[Customer::USER_DATA_COOKIE_NAME => null], new ParameterBag()],
            // Case #3.
            [[Customer::USER_DATA_COOKIE_NAME => 'test'], new ParameterBag()],
            // Case #4.
            [[Customer::USER_DATA_COOKIE_NAME => '{"array":[]}'], new ParameterBag()],
            // Case #5.
            [[], new ParameterBag()],
        ];
    }

    /**
     * Tests getting user data from cookie.
     *
     * @param array        $cookies
     * @param ParameterBag $expectedResult
     *
     * @dataProvider cookieProvider
     */
    public function testGetUserData($cookies, $expectedResult)
    {
        $instance = new Customer();

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request->cookies = new ParameterBag($cookies);

        /** @var RequestStack|\PHPUnit_Framework_MockObject_MockObject $requestStack */
        $requestStack = $this->getMockBuilder('Symfony\Component\HttpFoundation\RequestStack')
            ->disableOriginalConstructor()
            ->getMock();
        $requestStack->expects($this->any())->method('getCurrentRequest')->willReturn($request);
        $instance->setRequestStack($requestStack);

        $this->assertEquals($expectedResult, $instance->getUserData());
    }
}
