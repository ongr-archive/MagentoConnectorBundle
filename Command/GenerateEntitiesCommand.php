<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Command;

use ONGR\MagentoConnectorBundle\Generator\EntityGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCommand;
use Sensio\Bundle\GeneratorBundle\Command\Validators;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Class GenerateEntitiesCommand.
 */
class GenerateEntitiesCommand extends GenerateDoctrineCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ongr:magento:generate:entities')
            ->setAliases(['generate:ongr:magento:entities'])
            ->setDescription('Generates stub entities required for connector.')
            ->addArgument('bundle', InputArgument::REQUIRED, 'Bundle in which entities will be generated')
            ->addOption('configure', null, InputOption::VALUE_NONE, 'Option to add configuration to app config');
    }

    /**
     * @return BundleInterface
     */
    protected function getConnectorBundle()
    {
        return $this->getContainer()->get('kernel')->getBundle('ONGRMagentoConnectorBundle');
    }

    /**
     * {@inheritdoc}
     */
    protected function createGenerator()
    {
        return new EntityGenerator(
            $this->getConnectorBundle(),
            $this->getContainer()->get('kernel')->getRootDir()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bundle = $input->getArgument('bundle');
        $bundle = Validators::validateBundleName($bundle);
        $bundle = $this->getContainer()->get('kernel')->getBundle($bundle);

        /** @var EntityGenerator $generator */
        $generator = $this->getGenerator($this->getConnectorBundle());
        $generator->generate($bundle, $input->getOption('configure'));

    }
}
