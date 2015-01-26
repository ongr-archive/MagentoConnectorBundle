<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * ElasticSearch Price object.
 *
 * @ES\Object
 */
class PriceObject
{
    /**
     * @var float
     *
     * @ES\Property(name="price", type="float")
     */
    private $price;

    /**
     * @param float $price
     */
    public function __construct($price = null)
    {
        $this->setPrice($price);
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}
