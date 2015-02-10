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
 * ElasticSearch Url object.
 *
 * @ES\Object
 */
class UrlObject
{
    /**
     * @var string
     *
     * @ES\Property(name="url", type="string")
     */
    protected $url;

    /**
     * @var string
     *
     * @ES\Property(name="key", type="string", index="no")
     */
    protected $key;

    /**
     * @var string
     *
     * @ES\Property(name="cdn_url", type="string")
     */
    protected $cdnUrl;

    /**
     * @return string
     */
    public function getCdnUrl()
    {
        return $this->cdnUrl;
    }

    /**
     * @param string $cdn_url
     */
    public function setCdnUrl($cdn_url)
    {
        $this->cdnUrl = $cdn_url;
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

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
