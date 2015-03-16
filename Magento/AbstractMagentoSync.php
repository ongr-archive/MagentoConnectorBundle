<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Magento;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AbstractMagentoSync.
 */
abstract class AbstractMagentoSync
{
    /**
     * Parameter name for syncing with magento.
     */
    const MAGENTO_BACK_URL_PARAM_NAME = 'OngrUrl';

    /**
     * @var string
     */
    private $magentoUrl;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @return string
     */
    public function getMagentoUrl()
    {
        return $this->magentoUrl;
    }

    /**
     * @param string $magentoUrl
     *
     * @return $this
     */
    public function setMagentoUrl($magentoUrl)
    {
        $this->magentoUrl = $magentoUrl;

        return $this;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return $this
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;

        return $this;
    }
}
