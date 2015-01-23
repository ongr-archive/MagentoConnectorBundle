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

use ONGR\MagentoConnectorBundle\Tests\app\fixtures\ExpectedDocuments\ExpectedDocuments;

abstract class AbstractGetterSetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DocumentInterface
     */
    protected $document;

    /**
     * Attributes test data provider.
     *
     * @return array
     */
    abstract public function attributesDataProvider();

    /**
     * Test getters and setters.
     *
     * @param string $setter
     * @param string $getter
     * @param string $expectedMethod
     * @param string $addObject
     * @param string $stringSetter
     * @param string $stringForSetter
     *
     * @dataProvider attributesDataProvider
     */
    public function testGettersAndSetters(
        $setter,
        $getter,
        $expectedMethod,
        $addObject = null,
        $stringSetter = null,
        $stringForSetter = null
    ) {
        $this->document->$setter(ExpectedDocuments::$expectedMethod(1));
        $this->assertEquals(ExpectedDocuments::$expectedMethod(1), $this->document->$getter());

        if (!empty($addObject)) {
            $this->document->$addObject(ExpectedDocuments::$expectedMethod(1, 1)[0]);
            $this->assertEquals(
                ExpectedDocuments::$expectedMethod(2),
                $this->document->$getter()
            );
            $this->assertEquals(2, count($this->document->$getter()));
        }

        if (!empty($stringSetter)) {
            $this->document->$stringSetter($stringForSetter);
            $this->assertEquals(
                ExpectedDocuments::$expectedMethod(3),
                $this->document->$getter()
            );
            $this->assertEquals(3, count($this->document->$getter()));
        }
    }
}
