<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier;

use ONGR\MagentoConnectorBundle\Entity\CmsPage;
use ONGR\MagentoConnectorBundle\Entity\CmsPageStore;
use ONGR\MagentoConnectorBundle\Modifier\ContentModifier;
use ONGR\MagentoConnectorBundle\Tests\Helpers\ContentDocument;

class ContentModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify method.
     */
    public function testModify()
    {
        $modifier = new ContentModifier();

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
        $expectedDocument->id = 1;
        $expectedDocument->slug = 'slug';
        $expectedDocument->title = 'title';
        $expectedDocument->content = '<h1>head</h1>content';
        $expectedDocument->url = ['slug/'];
        $expectedDocument->expired_url = [];

        $document = new ContentDocument();

        $modifier->modify($document, $entity);

        $this->assertEquals($expectedDocument, $document);
    }
}
