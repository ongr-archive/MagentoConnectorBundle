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
 * Entity for table "eav_attribute".
 *
 * @ORM\MappedSuperclass
 */
class EavAttribute
{
    /**
     * @var int
     *
     * @ORM\Column(name="attribute_id", type="integer", nullable=false)
     * @ORM\Id
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="entity_type_id", type="integer", nullable=false)
     */
    protected $entityTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_code", type="string", nullable=false)
     */
    protected $attributeCode;

    /**
     * @var CatalogProductEntityInt
     *
     * @ORM\OneToOne(targetEntity="CatalogProductEntityInt", inversedBy="eavAttribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="attribute_id", nullable=false)
     */
    protected $catalogProductEntityInt;

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
    public function getEntityTypeId()
    {
        return $this->entityTypeId;
    }

    /**
     * @param int $entityTypeId
     *
     * @return self
     */
    public function setEntityTypeId($entityTypeId)
    {
        $this->entityTypeId = $entityTypeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAttributeCode()
    {
        return $this->attributeCode;
    }

    /**
     * @param string $attributeCode
     *
     * @return self
     */
    public function setAttributeCode($attributeCode)
    {
        $this->attributeCode = $attributeCode;

        return $this;
    }

    /**
     * @return CatalogProductEntityInt
     */
    public function getCatalogProductEntityInt()
    {
        return $this->catalogProductEntityInt;
    }

    /**
     * @param CatalogProductEntityInt $catalogProductEntityInt
     *
     * @return self
     */
    public function setCatalogProductEntityInt($catalogProductEntityInt)
    {
        $this->catalogProductEntityInt = $catalogProductEntityInt;

        return $this;
    }
}
