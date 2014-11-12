<?php

namespace ONGR\MagentoConnectorBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * Initialises ArrayCollections.
     */
    public function __construct()
    {
        $this->integerAttributes = new ArrayCollection();
        $this->varcharAttributes = new ArrayCollection();
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
     * @param CatalogCategoryEntityInt $attribute
     *
     * @return self
     */
    public function addIntegerAttribute($attribute)
    {
        $this->integerAttributes->add($attribute);

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
        $this->integerAttributes->removeElement($attribute);

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
}
