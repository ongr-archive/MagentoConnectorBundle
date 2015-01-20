<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\app\fixtures\MagentoTestBundle\EventListener;

use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use ONGR\ConnectionsBundle\EventListener\ImportFinishEventListener as ParentListener;

/**
 * This class is called by the pipeline at the end of import command.
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
