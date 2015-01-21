<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\app\fixtures\MagentoTestBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\MagentoConnectorBundle\Document\ContentDocument;

/**
 * Content document for testing.
 *
 * @ES\Document(type="content")
 */
class Content extends ContentDocument
{
}

