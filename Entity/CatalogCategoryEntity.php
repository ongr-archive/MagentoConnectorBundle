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
 * Entity for table "catalog_category_entity".
 *
 * @ORM\MappedSuperclass
 */
abstract class CatalogCategoryEntity
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
     * @ORM\Column(name="parent_id", type="integer")
     */
    protected $parentId;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    protected $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string")
     */
    protected $path;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    protected $level;

    /**
     * @var CatalogProductEntityInt[]
     *
     * @ORM\OneToMany(targetEntity="CatalogCategoryEntityInt", mappedBy="category")
     */
    protected $integerAttributes;

    /**
     * @var CatalogProductEntityVarchar[]
     *
     * @ORM\OneToMany(targetEntity="CatalogCategoryEntityVarchar", mappedBy="category")
     */
    protected $varcharAttributes;

    /**
     * @var CatalogCategoryProduct[]
     *
     * @ORM\OneToMany(targetEntity="CatalogCategoryProduct", mappedBy="category")
     */
    protected $products;

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
     * @param CatalogCategoryEntityInt[] $integerAttributes
     *
     * @return self
     */
    public function setIntegerAttributes($integerAttributes)
    {
        $this->integerAttributes = $integerAttributes;

        return $this;
    }

    /**
     * @param CatalogCategoryEntityInt $attribute
     *
     * @return self
     */
    public function addIntegerAttribute($attribute)
    {
        $this->integerAttributes[] = $attribute;

        return $this;
    }

    /**
     * Removes attribute from integerAttributes ArrayCollection.
     *
     * @param CatalogCategoryEntityInt $attribute
     *
     * @return self
     */
    public function removeIntegerAttribute($attribute)
    {
        $this->removeElement($attribute, $this->integerAttributes);

        return $this;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     *
     * @return self
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     *
     * @return self
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

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
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return self
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return CatalogCategoryProduct[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param CatalogCategoryProduct[] $products
     *
     * @return self
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @param CatalogCategoryProduct $product
     *
     * @return self
     */
    public function addProduct($product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Removes product from products ArrayColection.
     *
     * @param CatalogCategoryProduct $product
     *
     * @return self
     */
    public function removeProduct($product)
    {
        $this->removeElement($product, $this->products);

        return $this;
    }

    /**
     * Removes element from array.
     *
     * @param mixed $element
     * @param array $array
     */
    private function removeElement($element, &$array)
    {
        $key = array_search($element, $array, true);

        if ($key !== false) {
            unset($array[$key]);
        }
    }
}
