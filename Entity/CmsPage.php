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
 * Entity for table "cms_page".
 *
 * @ORM\MappedSuperclass
 */
abstract class CmsPage
{
    use GetterSetterHelperTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="page_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_time", type="datetime")
     */
    protected $creationTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime")
     */
    protected $updateTime;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string")
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string")
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="content_heading", type="string")
     */
    protected $heading;

    /**
     * @var int
     *
     * @ORM\Column(name="is_active", type="integer")
     */
    protected $active;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string")
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string")
     */
    protected $metaKeywords;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer")
     */
    protected $sortOrder;

    /**
     * @var CmsPageStore[]
     *
     * @ORM\OneToMany(targetEntity="CmsPageStore", mappedBy="page")
     */
    protected $stores;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationTime()
    {
        return $this->creationTime;
    }

    /**
     * @param \DateTime $creationTime
     *
     * @return self
     */
    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     *
     * @return self
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;

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
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return CmsPageStore[]
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * @param CmsPageStore[] $stores
     *
     * @return self
     */
    public function setStores($stores)
    {
        $this->stores = $stores;

        return $this;
    }

    /**
     * @param CmsPageStore $store
     *
     * @return self
     */
    public function addStore($store)
    {
        $this->stores[] = $store;

        return $this;
    }

    /**
     * Removes store from stores ArrayColection.
     *
     * @param CmsPageStore $store
     *
     * @return self
     */
    public function removeStore($store)
    {
        $this->removeElement($store, $this->stores);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param \DateTime $updateTime
     *
     * @return self
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * @return int
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }
}
