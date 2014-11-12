<?php

namespace ONGR\MagentoConnectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity for table "catalog_category_product".
 *
 * @ORM\MappedSuperclass
 */
class CatalogCategoryProduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var CatalogProductEntity
     *
     * @ORM\OneToOne(targetEntity="CatalogProductEntity", inversedBy="category")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="entity_id")
     */
    protected $product;

    /**
     * @var CatalogCategoryEntity
     *
     * @ORM\OneToOne(targetEntity="CatalogCategoryEntity")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="entity_id")
     */
    protected $category;

    /**
     * @return CatalogCategoryEntity
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param CatalogCategoryEntity $category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

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
}
