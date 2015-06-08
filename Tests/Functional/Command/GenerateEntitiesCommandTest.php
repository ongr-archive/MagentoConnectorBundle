<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Functional\Command;

use ONGR\MagentoConnectorBundle\Command\GenerateEntitiesCommand;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class GenerateEntitiesCommandTest.
 */
class GenerateEntitiesCommandTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->removeGenerated();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->removeGenerated();

        parent::tearDown();
    }

    /**
     * Cleans up config and classes.
     */
    private function removeGenerated()
    {
        /** @var Filesystem $filesystem */
        $filesystem = $this->client->getContainer()->get('filesystem');

        $configFile = $this->client->getKernel()->getRootDir() . '/config/config.yml';

        $entityDirectory = $this->getEntityDirectory();
        $DocumentDirectory = $this->getDocumentDirectory();

        $filesystem->remove([$configFile, $entityDirectory, $DocumentDirectory]);
    }

    /**
     * @return string
     */
    private function getEntityDirectory()
    {
        return $this->client->getKernel()->getBundle('CommandTestBundle')->getPath() . '/Entity';
    }

    /**
     * @return string
     */
    private function getDocumentDirectory()
    {
        return $this->client->getKernel()->getBundle('CommandTestBundle')->getPath() . '/Document';
    }

    /**
     * @return array
     */
    private function getEntityList()
    {
        return [
            'CatalogCategoryEntity',
            'CatalogCategoryEntityInt',
            'CatalogCategoryEntityVarchar',
            'CatalogCategoryProduct',
            'CatalogProductEntity',
            'CatalogProductEntityInt',
            'CatalogProductEntityText',
            'CatalogProductEntityVarchar',
            'CatalogProductIndexPrice',
            'CatalogProductWebsite',
            'CmsPage',
            'CmsPageStore',
            'EavAttribute',
        ];
    }

    /**
     * @return array
     */
    private function getDocumentList()
    {
        return [
            'CategoryDocument',
            'ContentDocument',
            'ProductDocument',
        ];
    }

    /**
     * Executes command.
     *
     * @param string $bundle
     * @param bool   $configure
     */
    private function execute($bundle, $configure)
    {
        $kernel = $this->client->getKernel();
        $application = new Application($kernel);
        $application->add(new GenerateEntitiesCommand());

        $command = $application->find('ongr:magento:generate:entities');

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'bundle' => $bundle,
                '--configure' => $configure,
            ]
        );
    }

    /**
     * Data provider for testCommand.
     *
     * @return array
     */
    public function commandTestProvider()
    {
        return [
            // Case #0. Do not Create configuration.
            [ 'CommandTestBundle', false ],
            // Case #1. Create configuration.
            [ 'CommandTestBundle', true ],
        ];
    }

    /**
     * Tests whether Entities and documents are created correctly.
     *
     * @param string $bundle
     * @param bool   $configure
     *
     * @dataProvider commandTestProvider
     */
    public function testCommand($bundle, $configure)
    {
        $this->execute($bundle, $configure);

        foreach ($this->getDocumentList() as $document) {
            $this->assertFileExists($this->getDocumentDirectory() . "/{$document}.php");
        }

        foreach ($this->getEntityList() as $entity) {
            $this->assertFileExists($this->getEntityDirectory() . "/{$entity}.php");
        }

        if ($configure) {
            $this->assertFileEquals(
                $this->client->getKernel()->getRootDir() . '/config/config.yml.assert',
                $this->client->getKernel()->getRootDir() . '/config/config.yml'
            );
        } else {
            $this->assertFileNotExists(
                $this->client->getKernel()->getRootDir() . '/config/config.yml.'
            );
        }
    }

    /**
     * Tests Exception when document exists.
     */
    public function testDocumentExists()
    {
        /** @var Filesystem $filesystem */
        $filesystem = $this->client->getContainer()->get('filesystem');

        $filesystem->mkdir($this->getDocumentDirectory());
        $filesystem->touch($this->getDocumentDirectory() . '/ProductDocument.php');
        $this->setExpectedException(
            'RuntimeException',
            'Document "ONGR\MagentoConnectorBundle\Tests\app\fixtures\CommandTestBundle\Document\ProductDocument"'
            . ' already exists.'
        );
        $this->execute('CommandTestBundle', false);
    }

    /**
     * Tests Exception when entity exists.
     */
    public function testEntityExists()
    {
        /** @var Filesystem $filesystem */
        $filesystem = $this->client->getContainer()->get('filesystem');

        $filesystem->mkdir($this->getEntityDirectory());
        $filesystem->touch($this->getEntityDirectory() . '/CatalogProductEntity.php');
        $this->setExpectedException(
            'RuntimeException',
            'Entity "ONGR\MagentoConnectorBundle\Tests\app\fixtures\CommandTestBundle\Entity\CatalogProductEntity"'
            . ' already exists.'
        );
        $this->execute('CommandTestBundle', false);
    }
}
