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
use ONGR\MagentoConnectorBundle\Document\ProductDocument;

/**
 * Product document for testing.
 *
 * @ES\Document(type="product")
 * @ES\Skip({"name"})
 * @ES\Inherit({"price"})
 */
class Product extends ProductDocument
{
}

