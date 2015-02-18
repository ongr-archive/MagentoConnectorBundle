<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\MagentoConnectorBundle\Tests\Functional;

use ONGR\ConnectionsBundle\Tests\Functional\AbstractTestCase as ParentTestBase;

/**
 * Class TestBase.
 */
abstract class AbstractTestCase extends ParentTestBase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->setSetUpDbFile('/fixtures/magento_db.sql');

        parent::setUp();
    }
}
