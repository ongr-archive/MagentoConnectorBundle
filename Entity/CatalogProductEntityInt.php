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
 * Entity for table "catalog_product_entity_int".
 *
 * @ORM\MappedSuperclass
 */
class CatalogProductEntityInt
{
    /**
     * @var int
     *
     * @ORM\Column(name="value_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var CatalogProductEntity
     *
     * @ORM\ManyToOne(targetEntity="CatalogProductEntity", inversedBy="integerAttributes")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="entity_id")
     */
    protected $product;

    /**
     * @var int
     *
     * @ORM\Column(name="attribute_id", type="integer")
     */
    protected $attributeId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="integer")
     */
    protected $value;

    /**
     * @var int
     *
     * @ORM\Column(name="store_id", type="integer")
     */
    protected $store;

    /**
     * @var EavAttribute
     *
     * @ORM\OneToOne(targetEntity="EavAttribute", mappedBy="catalogProductEntityInt", orphanRemoval=true)
     */
    protected $eavAttribute;

    /**
     * @return int
     */
    public function getAttributeId()
    {
        return $this->attributeId;
    }

    /**
     * @param int $attributeId
     *
     * @return self
     */
    public function setAttributeId($attributeId)
    {
        $this->attributeId = $attributeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

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
     * @return int
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param int $store
     *
     * @return self
     */
    public function setStore($store)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * @return EavAttribute
     */
    public function getEavAttribute()
    {
        return $this->eavAttribute;
    }

    /**
     * @param EavAttribute $eavAttribute
     *
     * @return self
     */
    public function setEavAttribute($eavAttribute)
    {
        $this->eavAttribute = $eavAttribute;

        return $this;
    }
}
