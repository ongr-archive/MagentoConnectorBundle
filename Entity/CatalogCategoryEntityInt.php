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
 * Entity for table "catalog_category_entity_int".
 *
 * @ORM\MappedSuperclass
 */
class CatalogCategoryEntityInt extends AbstractCatalogCategoryEntityAttribute
{
    /**
     * @var CatalogCategoryEntity
     *
     * @ORM\ManyToOne(targetEntity="CatalogCategoryEntity", inversedBy="integerAttributes")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="entity_id")
     */
    protected $category;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    protected $value;

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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
