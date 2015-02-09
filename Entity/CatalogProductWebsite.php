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
 * Entity for table "catalog_product_website".
 *
 * @ORM\MappedSuperclass
 */
abstract class CatalogProductWebsite
{
    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    protected $id;

    /**
     * @var CatalogProductEntity
     *
     * @ORM\ManyToOne(targetEntity="CatalogProductEntity", inversedBy="websiteIds")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="entity_id")
     */
    protected $product;

    /**
     * @var int
     *
     * @ORM\Column(name="website_id", type="integer")
     * @ORM\Id
     */
    protected $websiteId;

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
     * @return int
     */
    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    /**
     * @param int $websiteId
     *
     * @return self
     */
    public function setWebsiteId($websiteId)
    {
        $this->websiteId = $websiteId;

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
}
