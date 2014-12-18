<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier;

use ONGR\ConnectionsBundle\Import\Item\ImportItem;
use ONGR\MagentoConnectorBundle\Entity\CmsPage;
use ONGR\MagentoConnectorBundle\Entity\CmsPageStore;
use ONGR\MagentoConnectorBundle\Modifier\ContentModifier;
use ONGR\MagentoConnectorBundle\Documents\ContentDocument;

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

        /** @var CmsPageStore $entity */
        $entity = $this->getMockForAbstractClass('ONGR\MagentoConnectorBundle\Entity\CmsPageStore');
        $entity->setPage($page);

        $expectedDocument = new ContentDocument();
        $expectedDocument->setId(1);
        $expectedDocument->setSlug('slug');
        $expectedDocument->setTitle('title');
        $expectedDocument->setContent('content');
        $expectedDocument->setHeading('head');
        $expectedDocument->setExpiredUrl([]);

        $document = new ContentDocument();
        $item = new ImportItem($entity, $document);

        $method = new \ReflectionMethod(
            'ONGR\MagentoConnectorBundle\Modifier\ContentModifier',
            'modify'
        );
        $method->setAccessible(true);
        $method->invoke(new ContentModifier($shopId), $item);

        $this->assertEquals($expectedDocument, $document);
    }
}
