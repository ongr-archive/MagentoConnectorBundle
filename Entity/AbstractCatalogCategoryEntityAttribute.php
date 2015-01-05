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
 * Abstract category attribute.
 */
abstract class AbstractCatalogCategoryEntityAttribute
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
     * @var int
     *
     * @ORM\Column(name="attribute_id", type="integer")
     */
    protected $attributeId;

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
     * @return CatalogCategoryEntity
     */
    abstract public function getCategory();

    /**
     * @param CatalogCategoryEntity $category
     *
     * @return self
     */
    abstract public function setCategory($category);

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
     * @return mixed
     */
    abstract public function getValue();

    /**
     * @param mixed $value
     *
     * @return self
     */
    abstract public function setValue($value);

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
