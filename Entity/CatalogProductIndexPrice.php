<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity for table "catalog_product_index_price".
 *
 * @ORM\MappedSuperclass
 */
abstract class CatalogProductIndexPrice
{
    /**
     * @var int
     *
     * @ORM\Column(name="entity_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var CatalogProductEntity
     *
     * @ORM\ManyToOne(targetEntity="CatalogProductEntity", inversedBy="prices")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="entity_id")
     */
    protected $product;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    protected $price;

    /**
     * @var float
     *
     * @ORM\Column(name="final_price", type="float")
     */
    protected $finalPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="min_price", type="float")
     */
    protected $minPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="max_price", type="float")
     */
    protected $maxPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="tier_price", type="float")
     */
    protected $tierPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="group_price", type="float")
     */
    protected $groupPrice;

    /**
     * @return float
     */
    public function getFinalPrice()
    {
        return $this->finalPrice;
    }

    /**
     * @param float $finalPrice
     *
     * @return self
     */
    public function setFinalPrice($finalPrice)
    {
        $this->finalPrice = $finalPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getGroupPrice()
    {
        return $this->groupPrice;
    }

    /**
     * @param float $groupPrice
     *
     * @return self
     */
    public function setGroupPrice($groupPrice)
    {
        $this->groupPrice = $groupPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return float
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * @param float $maxPrice
     *
     * @return self
     */
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * @param float $minPrice
     *
     * @return self
     */
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
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
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return CatalogProductEntity
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param CatalogProductEntity $product
     *
     * @return self
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return float
     */
    public function getTierPrice()
    {
        return $this->tierPrice;
    }

    /**
     * @param float $tierPrice
     *
     * @return self
     */
    public function setTierPrice($tierPrice)
    {
        $this->tierPrice = $tierPrice;

        return $this;
    }
}
