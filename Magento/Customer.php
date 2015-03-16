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

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Responsible for getting customer data from magento.
 */
class Customer extends AbstractMagentoSync
{
    /**
     * Name of the cookie where user data is saved.
     */
    const USER_DATA_COOKIE_NAME = 'ongr_user';

    /**
     * Path to login in magento.
     */
    const LOGIN_PATH = '/customer/account/login';

    /**
     * Path to logout in magento.
     */
    const LOGOUT_PATH = '/customer/account/logout';

    /**
     * @var ParameterBag
     */
    private $userData;

    /**
     * Appends current uri to a url.
     *
     * @param string $url
     *
     * @return string
     */
    private function appendReturnUrl($url)
    {
        $backUrl = $this->getRequestStack()->getMasterRequest()->getUri();

        return $url . '?' . http_build_query([self::MAGENTO_RETURN_URL_PARAM_NAME => $backUrl]);
    }

    /**
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->appendReturnUrl($this->getMagentoUrl() . self::LOGOUT_PATH);
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->appendReturnUrl($this->getMagentoUrl() . self::LOGIN_PATH);
    }

    /**
     * Ensures user data is valid by removing invalid data.
     *
     * @param mixed $data
     *
     * @return ParameterBag
     */
    private function formatUserData($data)
    {
        if (!is_array($data)) {
            $data = [];
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                unset($data[$key]);
            }
        }

        return new ParameterBag($data);
    }

    /**
     * Gets user data.
     *
     * @return ParameterBag
     */
    public function getUserData()
    {
        if ($this->userData === null) {
            $request = $this->getRequestStack()->getCurrentRequest();
            $data = json_decode($request->cookies->get(self::USER_DATA_COOKIE_NAME, '[]'), true);
            $this->userData = $this->formatUserData($data);
        }

        return $this->userData;
    }

    /**
     * @param ParameterBag $userData
     *
     * @return $this
     */
    public function setUserData(ParameterBag $userData)
    {
        $this->userData = $userData;

        return $this;
    }
}
