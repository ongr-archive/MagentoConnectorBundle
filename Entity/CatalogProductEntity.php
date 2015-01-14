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
use ONGR\MagentoConnectorBundle\Helpers\GetterSetterHelperTrait;

/**
 * Entity for table "catalog_product_entity".
 *
 * @ORM\MappedSuperclass
 */
abstract class CatalogProductEntity
{
    use GetterSetterHelperTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="entity_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="attribute_set_id", type="integer")
     */
    protected $attributeSetId;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string")
     */
    protected $sku;

    /**
     * @var CatalogProductIndexPrice[]
     *
     * @ORM\OneToMany(targetEntity="CatalogProductIndexPrice", mappedBy="product")
     */
    protected $prices;

    /**
     * @var CatalogProductEntityInt[]
     *
     * @ORM\OneToMany(targetEntity="CatalogProductEntityInt", mappedBy="product")
     */
    protected $integerAttributes;

    /**
     * @var CatalogProductEntityText[]
     *
     * @ORM\OneToMany(targetEntity="CatalogProductEntityText", mappedBy="product")
     */
    protected $textAttributes;

    /**
     * @var CatalogProductEntityVarchar[]
     *
     * @ORM\OneToMany(targetEntity="CatalogProductEntityVarchar", mappedBy="product")
     */
    protected $varcharAttributes;

    /**
     * @var CatalogCategoryProduct[]
     *
     * @ORM\OneToMany(targetEntity="CatalogCategoryProduct", mappedBy="product")
     */
    protected $categories;

    /**
     * @return CatalogCategoryProduct[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param CatalogCategoryProduct[] $categories
     *
     * @return self
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param CatalogCategoryProduct $category
     *
     * @return self
     */
    public function addCategory($category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Removes category from categories ArrayColection.
     *
     * @param CatalogCategoryProduct $category
     *
     * @return self
     */
    public function removeCategory($category)
    {
        $this->removeElement($category, $this->categories);

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * @return CatalogProductEntityInt[]
     */
    public function getIntegerAttributes()
    {
        return $this->integerAttributes;
    }

    /**
     * @param CatalogProductEntityInt[] $integerAttributes
     *
     * @return self
     */
    public function setIntegerAttributes($integerAttributes)
    {
        $this->integerAttributes = $integerAttributes;

        return $this;
    }

    /**
     * @param CatalogProductEntityInt $attribute
     *
     * @return self
     */
    public function addIntegerAttribute($attribute)
    {
        $this->integerAttributes[] = $attribute;

        return $this;
    }

    /**
     * Removes attribute from integerAttributes ArrayColection.
     *
     * @param CatalogProductEntityInt $attribute
     *
     * @return self
     */
    public function removeIntegerAttribute($attribute)
    {
        $this->removeElement($attribute, $this->integerAttributes);

        return $this;
    }

    /**
     * @return CatalogProductIndexPrice[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param CatalogProductIndexPrice[] $prices
     *
     * @return self
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;

        return $this;
    }

    /**
     * @param CatalogProductIndexPrice $price
     *
     * @return self
     */
    public function addPrice($price)
    {
        $this->prices[] = $price;

        return $this;
    }

    /**
     * Removes price from prices ArrayColection.
     *
     * @param CatalogProductIndexPrice $price
     *
     * @return self
     */
    public function removePrice($price)
    {
        $this->removeElement($price, $this->prices);

        return $this;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     *
     * @return self
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return CatalogProductEntityText[]
     */
    public function getTextAttributes()
    {
        return $this->textAttributes;
    }

    /**
     * @param CatalogProductEntityText[] $textAttributes
     *
     * @return self
     */
    public function setTextAttributes($textAttributes)
    {
        $this->textAttributes = $textAttributes;

        return $this;
    }

    /**
     * @param CatalogProductEntityText $attribute
     *
     * @return self
     */
    public function addTextAttribute($attribute)
    {
        $this->textAttributes[] = $attribute;

        return $this;
    }

    /**
     * Removes attribute from textAttributes ArrayCollection.
     *
     * @param CatalogProductEntityText $attribute
     *
     * @return self
     */
    public function removeTextAttribute($attribute)
    {
        $this->removeElement($attribute, $this->textAttributes);

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return CatalogProductEntityVarchar[]
     */
    public function getVarcharAttributes()
    {
        return $this->varcharAttributes;
    }

    /**
     * @param CatalogProductEntityVarchar[] $varcharAttributes
     *
     * @return self
     */
    public function setVarcharAttributes($varcharAttributes)
    {
        $this->varcharAttributes = $varcharAttributes;

        return $this;
    }

    /**
     * @param CatalogProductEntityVarchar $attribute
     *
     * @return self
     */
    public function addVarcharAttribute($attribute)
    {
        $this->varcharAttributes[] = $attribute;

        return $this;
    }

    /**
     * Removes attribute from varcharAttributes ArrayCollection.
     *
     * @param CatalogProductEntityVarchar $attribute
     *
     * @return self
     */
    public function removeVarcharAttribute($attribute)
    {
        $this->removeElement($attribute, $this->varcharAttributes);

        return $this;
    }

    /**
     * @return int
     */
    public function getAttributeSetId()
    {
        return $this->attributeSetId;
    }

    /**
     * @param int $attributeSetId
     *
     * @return self
     */
    public function setAttributeSetId($attributeSetId)
    {
        $this->attributeSetId = $attributeSetId;

        return $this;
    }
}
