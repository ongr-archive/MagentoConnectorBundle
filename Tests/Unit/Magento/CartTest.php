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

use ONGR\ElasticsearchBundle\ORM\Manager;
use ONGR\ElasticsearchBundle\ORM\Repository;
use ONGR\MagentoConnectorBundle\Document\ProductDocument;
use ONGR\MagentoConnectorBundle\Magento\Cart;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Tests Magento Cart.
 */
class CartTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests setters and getters.
     */
    public function testSettersGetters()
    {
        $instance = new Cart();

        $this->assertNull($instance->getManager());
        $this->assertNull($instance->getRouter());
        $this->assertNull($instance->getRepositoryName());

        /** @var UrlGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject $urlGenerator */
        $urlGenerator = $this->getMockBuilder('Symfony\Component\Routing\Generator\UrlGeneratorInterface')
            ->getMockForAbstractClass();
        $instance->setRouter($urlGenerator);
        $this->assertSame($urlGenerator, $instance->getRouter());

        /** @var Manager|\PHPUnit_Framework_MockObject_MockObject $manager */
        $manager = $this->getMockBuilder('ONGR\ElasticsearchBundle\ORM\Manager')
            ->disableOriginalConstructor()
            ->getMock();
        $instance->setManager($manager);
        $this->assertSame($manager, $instance->getManager());

        $repositoryName = 'products';
        $instance->setRepositoryName($repositoryName);
        $this->assertEquals($repositoryName, $instance->getRepositoryName());
    }

    /**
     * Initializes Magento Cart.
     *
     * @param Cart|null $instance
     *
     * @return Cart
     */
    private function getCart(Cart $instance = null)
    {
        if ($instance === null) {
            $instance = new Cart();
        }

        /** @var UrlGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject $urlGenerator */
        $urlGenerator = $this->getMockBuilder('Symfony\Component\Routing\Generator\UrlGeneratorInterface')
            ->getMockForAbstractClass();
        $instance->setRouter($urlGenerator);

        /** @var Manager|\PHPUnit_Framework_MockObject_MockObject $manager */
        $manager = $this->getMockBuilder('ONGR\ElasticsearchBundle\ORM\Manager')
            ->disableOriginalConstructor()
            ->getMock();
        $instance->setManager($manager);

        /** @var RequestStack|\PHPUnit_Framework_MockObject_MockObject $requestStack */
        $requestStack = $this->getMockBuilder('Symfony\Component\HttpFoundation\RequestStack')
            ->disableOriginalConstructor()
            ->getMock();
        $instance->setRequestStack($requestStack);

        $instance->setMagentoUrl('testing.url');

        return $instance;
    }

    /**
     * Tests getCheckoutUrl.
     */
    public function testGetCheckoutUrl()
    {
        $instance = $this->getCart();
        $this->assertEquals('testing.url' . Cart::CHECKOUT_PATH, $instance->getCheckoutUrl());
    }

    /**
     * Provider for cookie test.
     *
     * @return array
     */
    public function cookieDataProvider()
    {
        return [
            // Case #0. Empty array.
            [[Cart::CART_DATA_COOKIE_NAME => '[]'], []],
            // Case #1. Empty object.
            [[Cart::CART_DATA_COOKIE_NAME => '{}'], []],
            // Case #2. String.
            [[Cart::CART_DATA_COOKIE_NAME => 'as'], []],
            // Case #3. Array as value.
            [[Cart::CART_DATA_COOKIE_NAME => '{"11":[]}'], []],
            // Case #4. Valid single element.
            [[Cart::CART_DATA_COOKIE_NAME => '{"11":1}'], [11 => 1]],
            // Case #5. Multiple valid elements.
            [[Cart::CART_DATA_COOKIE_NAME => '{"11":1,"22":2}'], [11 => 1, 22 => 2]],
            // Case #6. Null.
            [[Cart::CART_DATA_COOKIE_NAME => null], []],
            // Case #7. No cookie.
            [[], []],
        ];
    }

    /**
     * Test getting data from cookie.
     *
     * @param array $cookies
     * @param array $expectedContent
     *
     * @dataProvider cookieDataProvider
     */
    public function testGetCartContent($cookies, $expectedContent)
    {
        $instance = $this->getCart();

        $parameters = new ParameterBag($cookies);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request->cookies = $parameters;

        /** @var RequestStack|\PHPUnit_Framework_MockObject_MockObject $requestStack */
        $requestStack = $instance->getRequestStack();
        $requestStack->expects($this->any())->method('getCurrentRequest')->willReturn($request);

        $this->assertEquals($expectedContent, $instance->getCartContent());
    }

    /**
     * Tests manipulation with cart.
     */
    public function testCartContent()
    {
        $instance = $this->getCart();

        $content = [11 => 2];
        $instance->setCartContent($content);
        $this->assertEquals($content, $instance->getCartContent());

        $instance->addProduct(22);
        $content[22] = 1;
        $this->assertEquals($content, $instance->getCartContent());
        $this->assertEquals(count($content), count($instance));

        $instance->addProduct(22, 2);
        $content[22] = 3;
        $this->assertEquals($content, $instance->getCartContent());

        $instance->removeProduct(11);
        unset($content[11]);
        $this->assertEquals($content, $instance->getCartContent());
        $this->assertEquals(count($content), count($instance));

        $response = $instance->getUpdateResponse();
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $response);
        $this->assertEquals('testing.url?OngrProducts%5B22%5D=3', $response->getTargetUrl());
    }

    /**
     * Data provider for testGetCartDocuments.
     *
     * @return array
     */
    public function cartDocumentProvider()
    {
        $data = [];

        // Case #0.
        $data[] = [
            [],
            [],
            [],
        ];

        // Case #1.
        $document = new ProductDocument();
        $document->setId(11);
        $data[] = [
            [11 => 2],
            [$document],
            [['document' => $document, 'quantity' => 2]],
        ];

        // Case #2.
        $document = new ProductDocument();
        $document->setId(11);
        $document2 = new ProductDocument();
        $document2->setId(13);
        $data[] = [
            [13 => 2, 11 => 3],
            [$document, $document2],
            [
                ['document' => $document, 'quantity' => 3],
                ['document' => $document2, 'quantity' => 2],
            ],
        ];

        return $data;
    }

    /**
     * Tests getting product documents of cart products.
     *
     * @param array $cart
     * @param array $documents
     * @param array $expectedResult
     *
     * @dataProvider cartDocumentProvider
     */
    public function testGetCartDocuments($cart, $documents, $expectedResult)
    {
        $instance = $this->getCart();
        $instance->setCartContent($cart);

        /** @var Repository|\PHPUnit_Framework_MockObject_MockObject $repository */
        $repository = $this->getMockBuilder('ONGR\ElasticsearchBundle\ORM\Repository')
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())->method('execute')->willReturn($documents);

        /** @var Manager|\PHPUnit_Framework_MockObject_MockObject $manager */
        $manager = $instance->getManager();
        $manager->expects($this->once())->method('getRepository')->willReturn($repository);

        $this->assertEquals($expectedResult, $instance->getCartDocuments());
    }

    /**
     * Data provider for testGetErrorDocuments.
     *
     * @return array
     */
    public function errorDocumentProvider()
    {
        $data = [];

        // Case #0.
        $data[] = [
            [],
            [],
            [],
        ];

        // Case #1.
        $data[] = [
            ['e' => null],
            [],
            [],
        ];

        // Case #2.
        $data[] = [
            ['e' => []],
            [],
            [],
        ];

        // Case #3.
        $document = new ProductDocument();
        $document->setId(12);
        $data[] = [
            ['e' => [12]],
            [$document],
            [$document],
        ];

        return $data;
    }

    /**
     * Tests getting documents of failed products.
     *
     * @param array $query
     * @param array $documents
     * @param array $expectedResult
     *
     * @dataProvider errorDocumentProvider
     */
    public function testGetErrorDocuments($query, $documents, $expectedResult)
    {
        $instance = $this->getCart();

        $parameters = new ParameterBag($query);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request->query = $parameters;

        /** @var RequestStack|\PHPUnit_Framework_MockObject_MockObject $requestStack */
        $requestStack = $instance->getRequestStack();
        $requestStack->expects($this->any())->method('getCurrentRequest')->willReturn($request);

        /** @var Repository|\PHPUnit_Framework_MockObject_MockObject $repository */
        $repository = $this->getMockBuilder('ONGR\ElasticsearchBundle\ORM\Repository')
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->any())->method('execute')->willReturn($documents);

        /** @var Manager|\PHPUnit_Framework_MockObject_MockObject $manager */
        $manager = $instance->getManager();
        $manager->expects($this->any())->method('getRepository')->willReturn($repository);

        $this->assertEquals($expectedResult, $instance->getErrorDocuments());
    }
}
