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
use ONGR\ContentBundle\Document\AbstractCategoryDocument;

/**
 * ElasticSearch Category document.
 *
 * @ES\Document(type="category")
 */
class CategoryDocument extends AbstractCategoryDocument
{
    const ROOT_ID = 'rootid';

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
     * @ES\Property(name="urls", type="object", objectName="ONGRMagentoConnectorBundle:UrlObject", multiple=true)
     */
    protected $urls = [];

    /**
     * @var string[] Array of expired urls hashes.
     *
     * @ES\Property(name="expired_urls", type="string", multiple=true)
     */
    protected $expiredUrls = [];

    /**
     * @var string
     *
     * @ES\Property(name="path", type="string")
     */
    protected $path;

    /**
     * @return string[]
     */
    public function getExpiredUrls()
    {
        return $this->expiredUrls;
    }

    /**
     * @param string[] $expiredUrls
     */
    public function setExpiredUrls($expiredUrls)
    {
        $this->expiredUrls = $expiredUrls;
    }

    /**
     * @param string $expiredUrl
     */
    public function addExpiredUrl($expiredUrl)
    {
        $this->expiredUrls[] = $expiredUrl;
    }

    /**
     * @return \Iterator|UrlObject[]
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param \Iterator|UrlObject[] $urls
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }

    /**
     * @param UrlObject $urlObject
     */
    public function addUrl($urlObject)
    {
        $this->urls[] = $urlObject;
    }

    /**
     * @param string $urlString
     */
    public function addUrlString($urlString)
    {
        $urlObject = new UrlObject();
        $urlObject->setUrl($urlString);
        $this->urls[] = $urlObject;
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
