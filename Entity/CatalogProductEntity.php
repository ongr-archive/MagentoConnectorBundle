<?php

namespace ONGR\MagentoConnectorBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity for table "catalog_product_entity".
 *
 * @ORM\MappedSuperclass
 */
abstract class CatalogProductEntity
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
     * @var CatalogProductIndexPrice
     *
     * @ORM\OneToOne(targetEntity="CatalogProductIndexPrice")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="entity_id")
     */
    protected $price;

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
     * @var CatalogCategoryProduct
     *
     * @ORM\OneToOne(targetEntity="CatalogCategoryProduct", inversedBy="product")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="product_id")
     */
    protected $category;

    /**
     * Initialises ArrayCollections.
     */
    public function __construct()
    {
        $this->integerAttributes = new ArrayCollection();
        $this->textAttributes = new ArrayCollection();
        $this->varcharAttributes = new ArrayCollection();
    }

    /**
     * @return CatalogCategoryProduct
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param CatalogCategoryProduct $category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

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
        foreach ($integerAttributes as $attribute) {
            $this->addIntegerAttribute($attribute);
        }

        return $this;
    }

    /**
     * @param CatalogProductEntityInt $attribute
     *
     * @return self
     */
    public function addIntegerAttribute($attribute)
    {
        $this->integerAttributes->add($attribute);

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
        $this->integerAttributes->removeElement($attribute);

        return $this;
    }

    /**
     * @return CatalogProductIndexPrice
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param CatalogProductIndexPrice $price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

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
        foreach ($textAttributes as $attribute) {
            $this->addTextAttribute($attribute);
        }

        return $this;
    }

    /**
     * @param CatalogProductEntityText $attribute
     *
     * @return self
     */
    public function addTextAttribute($attribute)
    {
        $this->textAttributes->add($attribute);

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
        $this->textAttributes->removeElement($attribute);

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
        foreach ($varcharAttributes as $attribute) {
            $this->addVarcharAttribute($attribute);
        }

        return $this;
    }

    /**
     * @param CatalogProductEntityText $attribute
     *
     * @return self
     */
    public function addVarcharAttribute($attribute)
    {
        $this->varcharAttributes->add($attribute);

        return $this;
    }

    /**
     * Removes attribute from varcharAttributes ArrayCollection.
     *
     * @param CatalogProductEntityText $attribute
     *
     * @return self
     */
    public function removeVarcharAttribute($attribute)
    {
        $this->varcharAttributes->removeElement($attribute);

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
