<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Functional\Modifier;

use DateTime;
use ONGR\ConnectionsBundle\Command\SyncExecuteCommand;
use ONGR\ConnectionsBundle\Command\SyncProvideCommand;
use ONGR\ConnectionsBundle\Command\SyncStorageCreateCommand;
use ONGR\ConnectionsBundle\Sync\DiffProvider\Binlog\BinlogDiffProvider;
use ONGR\ConnectionsBundle\Sync\DiffProvider\Binlog\BinlogParser;
use ONGR\ConnectionsBundle\Sync\SyncStorage\SyncStorage;
use ONGR\ConnectionsBundle\Tests\Functional\ESDoctrineTestCase;
use ONGR\MagentoConnectorBundle\Document\CategoryDocument;
use ONGR\MagentoConnectorBundle\Document\CategoryObject;
use ONGR\MagentoConnectorBundle\Document\ContentDocument;
use ONGR\MagentoConnectorBundle\Document\ProductDocument;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Tests sync process all the way from binlog to ES.
 */
class SyncTest extends ESDoctrineTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->importData('Sync/Data/Data.sql');
    }

    /**
     * Test sync.
     */
    public function testSync()
    {
        $kernel = self::createClient()->getKernel();
        /** @var BinlogDiffProvider $binlog */
        $binlog = $kernel->getContainer()->get('test.sync.diff_provider.binlog_diff_provider');
        $binlog->setStartType(BinlogParser::START_TYPE_DATE);
        $binlog->setFrom(new DateTime('2000-00-00 00:00:00'));

        $application = new Application($kernel);
        $application->add(new SyncProvideCommand());
        $application->add(new SyncExecuteCommand());
        $application->add(new SyncStorageCreateCommand());

        $manager = $this->getManager();

        $provideCommand = $application->find('ongr:sync:provide');
        $executeCommand = $application->find('ongr:sync:execute');
        $createCommand = $application->find('ongr:sync:storage:create');

        $provideCommandTester = new CommandTester($provideCommand);
        $executeCommandTester = new CommandTester($executeCommand);
        $createCommandTester = new CommandTester($createCommand);

        $createCommandTester->execute(
            [
                'command' => $createCommand->getName(),
                'storage' => SyncStorage::STORAGE_MYSQL,
                '--shop-id' => 0,
            ]
        );

        $createCommandTester->execute(
            [
                'command' => $createCommand->getName(),
                'storage' => SyncStorage::STORAGE_MYSQL,
                '--shop-id' => 1,
            ]
        );

        $provideCommandTester->execute(
            [
                'command' => $provideCommand->getName(),
                'target' => 'magento',
            ]
        );
        foreach (['product', 'category', 'content'] as $type) {
            $executeCommandTester->execute(
                [
                    'command' => $executeCommand->getName(),
                    'target' => 'magento.' . $type,
                ]
            );
        }
        foreach ($this->getExpectedDocuments() as $repo => $data) {
            $repository = $manager->getRepository($repo);
            $search = $repository->createSearch();
            foreach ($repository->execute($search) as $document) {
                $expectedObject = $data['documents'][$document->getId()];

                $this->assertEquals($expectedObject->getId(), $document->getId());
                $this->assertEquals($expectedObject->getTitle(), $document->getTitle());

                if ($repo == 'ONGRMagentoConnectorBundle:ProductDocument') {
                    $expectedCategory = $expectedObject->getCategories();
                    $realCategory = $document->getCategories()->current();
                    $this->assertEquals($expectedCategory[0]->getId(), $realCategory->getId());

                    $expectedUrl = $expectedObject->getUrls()[0]->getUrl();
                    $realUrl = $document->getUrls()->current()->getUrl();
                    $this->assertEquals($expectedUrl, $realUrl);
                }
            }
        }
    }

    /**
     * GetExpectedDocuments.
     *
     * @return array
     */
    private function getExpectedDocuments()
    {
        $expectedDocuments = [
            'ONGRMagentoConnectorBundle:ProductDocument' => [
                'arrays' => ['Urls', 'Images', 'SmallImages', 'Categories'],
                'documents' => [],
            ],
            'ONGRMagentoConnectorBundle:CategoryDocument' => [
                'arrays' => ['Urls'],
                'documents' => [],
            ],
            'ONGRMagentoConnectorBundle:ContentDocument' => [
                'arrays' => [],
                'documents' => [],
            ],
        ];

        // Category.
        $expectedDocument = new CategoryDocument();
        $expectedDocument->setId('4');
        $expectedDocument->setScore(1.0);
        $expectedDocument->addUrlString('new-cat.html');
        $expectedDocument->setPath('/4');
        $expectedDocument->setSort(2);
        $expectedDocument->setActive(true);
        $expectedDocument->setParentId('magentorootid');
        $expectedDocument->setTitle('cat update');

        $id = $expectedDocument->getId();
        $expectedDocuments['ONGRMagentoConnectorBundle:CategoryDocument']['documents'][$id] = $expectedDocument;

        // Content.
        $expectedDocument = new ContentDocument();
        $expectedDocument->setId('8');
        $expectedDocument->setScore(1.0);
        $expectedDocument->setHeading('Heading');
        $expectedDocument->setSlug('newpage');
        $expectedDocument->setTitle('NewPageUpdated');
        $expectedDocument->setContent('<p>Content&nbsp;Updated</p>');

        $id = $expectedDocument->getId();
        $expectedDocuments['ONGRMagentoConnectorBundle:ContentDocument']['documents'][$id] = $expectedDocument;

        // Product with category and with url.
        $defaultCategory = new CategoryObject();
        $defaultCategory->setId(2);
        $defaultCategory->setTitle('Default Category');
        $defaultCategory->setPath('1/2');
        $defaultCategory->setCategories(['1', '2']);

        $expectedDocument = new ProductDocument();
        $expectedDocument->setSku('sku Update');
        $expectedDocument->setDescription('Simple desc Update');
        $expectedDocument->setTitle('Simple product Update');
        $expectedDocument->setId('1');
        $expectedDocument->setShortDescription('Simple short desc Update');
        $expectedDocument->setScore(1.0);
        $expectedDocument->addUrl('simple-product.html');
        $expectedDocument->addCategory($defaultCategory);
        $expectedDocument->addImageUrl('no_selection');
        $expectedDocument->addSmallImageUrl('no_selection');

        $id = $expectedDocument->getId();
        $expectedDocuments['ONGRMagentoConnectorBundle:ProductDocument']['documents'][$id] = $expectedDocument;

        $expectedDocument = new ProductDocument();
        $expectedDocument->setSku('sku');
        $expectedDocument->setDescription('New desc update');
        $expectedDocument->setTitle('simple product update');
        $expectedDocument->setId('2');
        $expectedDocument->setShortDescription('New desc update');
        $expectedDocument->setScore(1.0);
        $expectedDocument->addUrl('new-simple-product.html');
        $expectedDocument->addCategory($defaultCategory);
        $expectedDocument->addImageUrl('no_selection');
        $expectedDocument->addSmallImageUrl('no_selection');

        $id = $expectedDocument->getId();
        $expectedDocuments['ONGRMagentoConnectorBundle:ProductDocument']['documents'][$id] = $expectedDocument;

        return $expectedDocuments;
    }
}
