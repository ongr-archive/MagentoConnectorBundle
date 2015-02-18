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

use ONGR\ConnectionsBundle\Command\ImportFullCommand;
use ONGR\ElasticsearchBundle\ORM\Manager;
use ONGR\ElasticsearchBundle\ORM\Repository;
use ONGR\MagentoConnectorBundle\Tests\app\fixtures\ExpectedDocuments\ExpectedDocuments;
use ONGR\MagentoConnectorBundle\Tests\Functional\AbstractTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Functional test for ongr:magento:import commands.
 */
class ImportFullCommandTest extends AbstractTestCase
{
    /**
     * Check if a document is saved as expected after collecting data from providers.
     */
    public function testDefaultImportCommand()
    {
        $manager = $this->getServiceContainer()->get('es.manager.default');

        $kernel = $this->getClient()->getKernel();
        $application = new Application($kernel);
        $application->add(new ImportFullCommand());

        $command = $application->find('ongr:import:full');
        $commandTester = new CommandTester($command);
        $attributesForTest = $this->attributesData();

        $commandTester->execute(['command' => $command->getName()]);
        $actualDocuments = $this->getActualDocument('Product', $manager);
        $this->assertEquals(ExpectedDocuments::getProductDocument(), $actualDocuments);

        foreach ($attributesForTest as $value) {
            $commandTester->execute(
                [
                    'command' => $command->getName(),
                    'target' => 'magento.' . strtolower($value),
                ]
            );
            $actualDocuments = $this->getActualDocument($value, $manager);
            $method = 'get' . $value . 'Document';
            $this->assertEquals(ExpectedDocuments::$method(), $actualDocuments);
        }
    }

    /**
     * Attributes data.
     *
     * @return array
     */
    protected function attributesData()
    {
        return [
            'Product',
            'Category',
            'Content',
        ];
    }

    /**
     * Get actual documents from ES.
     *
     * @param string  $documentType
     * @param Manager $manager
     *
     * @return array $actualDocuments
     */
    protected function getActualDocument($documentType, $manager)
    {
        $repository = $manager->getRepository('MagentoTestBundle:' . $documentType);
        $search = $repository->createSearch();

        foreach ($repository->execute($search, Repository::RESULTS_ARRAY) as $document) {
            $actualDocuments[] = $document;
        }

        return $actualDocuments;
    }
}
