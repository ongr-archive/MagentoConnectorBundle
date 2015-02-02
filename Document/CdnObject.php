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
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;

/**
 * ElasticSearch Cdn object.
 *
 * @ES\Object
 */
class CdnObject implements DocumentInterface
{
    use DocumentTrait;

    /**
     * @var string
     */
    protected $cdn;

    /**
     * @return string
     */
    public function getCdn()
    {
        return $this->cdn;
    }

    /**
     * @param string $cdn
     */
    public function setCdn($cdn)
    {
        $this->cdn = $cdn;
    }
}
