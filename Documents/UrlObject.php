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
    private $url;

    /**
     * @var string
     *
     * @ES\Property(name="key", type="string", index="no")
     */
    private $urlKey;

    /**
     * @var CdnObject
     *
     * @ES\Property(name="cdn", type="object", objectName="ONGRTestingBundle:CdnObject")
     */
    private $cdn;

    /**
     * @return CdnObject
     */
    public function getCdn()
    {
        return $this->cdn;
    }

    /**
     * @param CdnObject $cdn
     */
    public function setCdn($cdn)
    {
        $this->cdn = $cdn;
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
     * @param string $urlKey
     */
    public function setUrlKey($urlKey)
    {
        $this->urlKey = $urlKey;
    }

    /**
     * @return string
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }
}
