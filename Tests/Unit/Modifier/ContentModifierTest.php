<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\MagentoConnectorBundle\Document\ContentDocument;
use ONGR\MagentoConnectorBundle\Entity\CmsPage;
use ONGR\MagentoConnectorBundle\Modifier\ContentModifier;

class ContentModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $shopId = 1;

        /** @var CmsPage $page */
        $page = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CmsPage');
        $page->setId(1);
        $page->setContent('content');
        $page->setHeading('head');
        $page->setSlug('slug');
        $page->setTitle('title');

        $expectedDocument = new ContentDocument();
        $expectedDocument->setId(1);
        $expectedDocument->setSlug('slug');
        $expectedDocument->setTitle('title');
        $expectedDocument->setContent('content');
        $expectedDocument->setHeading('head');
        $expectedDocument->setExpiredUrls([]);

        $document = new ContentDocument();
        $item = new ImportItem($page, $document);
        $event = new ItemPipelineEvent($item);
        $modifier = new ContentModifier($shopId);
        $modifier->onModify($event);

        $this->assertEquals($expectedDocument, $document);
    }
}
