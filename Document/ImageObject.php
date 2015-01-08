<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * ElasticSearch Image object.
 *
 * @ES\Object
 */
class ImageObject
{
    /**
     * @var string
     *
     * @ES\Property(name="url", type="string")
     */
    private $url;

    /**
     * @var string
     *
     * @ES\Property(name="title", type="string", index="no")
     */
    private $title;

    /**
     * @var string
     *
     * @ES\Property(name="description", type="string", index="no")
     */
    private $description;

    /**
     * @var object
     *
     * @ES\Property(name="cdn", type="object", objectName="ONGRMagentoConnectorBundle:CdnObject")
     */
    private $cdn;

    /**
     * @return object
     */
    public function getCdn()
    {
        return $this->cdn;
    }

    /**
     * @param object $cdn
     */
    public function setCdn($cdn)
    {
        $this->cdn = $cdn;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
