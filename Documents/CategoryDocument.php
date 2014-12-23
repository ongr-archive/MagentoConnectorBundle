<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Documents;

use ONGR\ContentBundle\Document\Traits\CategoryTrait;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;

/**
 * ElasticSearch Category document.
 *
 * @ES\Document
 */
class CategoryDocument implements DocumentInterface
{
    use DocumentTrait;
    use CategoryTrait;

    /**
     * Structure that represents possible URLs for the model.
     *
     * Eg.:
     *
     * <code>
     * array(
     *     array('url' => 'foo/'),
     *     array('url' => 'bar/', 'key' => 'bar_url'),
     * )
     * </code>
     *
     * @var UrlObject[]|\Iterator
     *
     * @ES\Property(name="url", type="object", objectName="MagentoConnectorBundle:UrlObject", multiple=true)
     */
    private $url = [];

    /**
     * @var string[] Array of expired url hashes.
     *
     * @ES\Property(name="expired_url", type="string", multiple=true)
     */
    private $expiredUrl = [];

    /**
     * @var string
     *
     * @ES\Property(name="path", type="string")
     */
    private $path;

    /**
     * @return \string[]
     */
    public function getExpiredUrl()
    {
        return $this->expiredUrl;
    }

    /**
     * @param \string[] $expiredUrl
     */
    public function setExpiredUrl($expiredUrl)
    {
        $this->expiredUrl = $expiredUrl;
    }

    /**
     * @param string $expiredUrl
     */
    public function addExpiredUrl($expiredUrl)
    {
        $this->expiredUrl[] = $expiredUrl;
    }

    /**
     * @return \Iterator|UrlObject[]
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param \Iterator|UrlObject[] $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param UrlObject $urlObject
     */
    public function addUrl($urlObject)
    {
        $this->url[] = $urlObject;
    }

    /**
     * @param string $urlString
     */
    public function addUrlString($urlString)
    {
        $urlObject = new UrlObject();
        $urlObject->setUrl($urlString);
        $this->url[] = $urlObject;
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
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
