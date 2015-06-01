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
use ONGR\RouterBundle\Document\UrlNested;

/**
 * ElasticSearch Url object.
 *
 * @ES\Object
 */
class UrlObject extends UrlNested
{
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
}
