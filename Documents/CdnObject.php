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
 * CdnObject document for testing.
 *
 * @ES\Object
 */
class CdnObject
{
    /**
     * @var string
     *
     * @ES\Property(name="cdn_url", type="string")
     */
    private $cdn_url;

    /**
     * @return string
     */
    public function getCdnUrl()
    {
        return $this->cdn_url;
    }

    /**
     * @param string $cdn_url
     */
    public function setCdnUrl($cdn_url)
    {
        $this->cdn_url = $cdn_url;
    }
}
