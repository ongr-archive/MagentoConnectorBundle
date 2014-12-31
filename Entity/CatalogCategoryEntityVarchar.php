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
 * Entity for table "catalog_category_entity_varchar".
 *
 * @ORM\MappedSuperclass
 */
abstract class CatalogCategoryEntityVarchar
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
     * @var CatalogCategoryEntity
     *
     * @ORM\ManyToOne(targetEntity="CatalogCategoryEntity", inversedBy="varcharAttributes")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="entity_id")
     */
    protected $category;

    /**
     * @var int
     *
     * @ORM\Column(name="attribute_id", type="integer")
     */
    protected $attributeId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string")
     */
    protected $value;

    /**
     * @var int
     *
     * @ORM\Column(name="store_id", type="integer")
     */
    protected $store;

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
}
