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

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\MagentoConnectorBundle\Document\ContentDocument;
use ONGR\MagentoConnectorBundle\Modifier\ContentModifier;
use ONGR\MagentoConnectorBundle\Tests\Functional\AbstractTestCase;

/**
 * Tests if category modifier works as expected.
 */
class ContentModifierTest extends AbstractTestCase
{
    /**
     * Test modification.
     */
    public function testModify()
    {
        $shopId = 1;

        $expectedEntity1 = new ContentDocument();
        $expectedEntity1->setId(2);
        $expectedEntity1->setContent('<div class="slideshow-container">Madison Island content</div>');
        $expectedEntity1->setTitle('Madison Island');
        $expectedEntity1->setSlug('home');

        $expectedEntity2 = new ContentDocument();
        $expectedEntity2->setId(3);
        $expectedEntity2->setContent('About us content');
        $expectedEntity2->setTitle('About Us');
        $expectedEntity2->setSlug('about-magento-demo-store');

        $expectedEntities = [$expectedEntity1, $expectedEntity2];

        $repository = $this->getEntityManager()->getRepository('ONGRMagentoConnectorBundleTest:CmsPage');
        $contentItems = [];
        $contentItems[0] = $repository->find('2');
        $contentItems[1] = $repository->find('3');

        $this->assertNotNull($contentItems[0]);
        $this->assertNotNull($contentItems[1]);

        $modifier = new ContentModifier($shopId);
        $createdContents = [];

        foreach ($contentItems as $contentItem) {
            $createdContent = new ContentDocument();
            $item = new ImportItem($contentItem, $createdContent);
            $event = new ItemPipelineEvent($item);
            $modifier->onModify($event);
            $createdContents[] = $createdContent;
        }

        $this->assertEquals($expectedEntities, $createdContents);
    }
}
