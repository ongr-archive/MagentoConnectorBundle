<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Functional\Fixtures\Sync\EventListener;

use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use ONGR\ConnectionsBundle\EventListener\ImportFinishEventListener as ParentListener;

/**
 * ImportFinishEventListener class.
 */
class ImportFinishEventListener extends ParentListener
{
    /**
     * {@inheritdoc}
     */
    public function onFinish()
    {
        try {
            parent::onFinish();
        } catch (BadRequest400Exception $e) {
            // Ignore Empty bulk requests.
        }
    }
}
