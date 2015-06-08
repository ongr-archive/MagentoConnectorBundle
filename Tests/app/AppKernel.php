<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new ONGR\ElasticsearchBundle\ONGRElasticsearchBundle(),
            new ONGR\ConnectionsBundle\ONGRConnectionsBundle(),
            new ONGR\MagentoConnectorBundle\ONGRMagentoConnectorBundle(),
            new ONGR\RouterBundle\ONGRRouterBundle(),
            new ONGR\MagentoConnectorBundle\Tests\app\fixtures\MagentoTestBundle\MagentoTestBundle(),
            new ONGR\MagentoConnectorBundle\Tests\app\fixtures\CommandTestBundle\CommandTestBundle(),
        ];
    }

    /**
     * Register container configuration.
     *
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
