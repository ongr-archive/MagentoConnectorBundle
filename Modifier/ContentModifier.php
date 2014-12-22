<?php

namespace ONGR\MagentoConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\MagentoConnectorBundle\Documents\ContentDocument;
use ONGR\MagentoConnectorBundle\Entity\CmsPage;
use ONGR\MagentoConnectorBundle\Entity\CmsPageStore;

/**
 * Modifies entities to match ongr content mapping.
 */
class ContentModifier extends AbstractImportModifyEventListener
{
    /**
     * @var int
     */
    protected $storeId;

    /**
     * @param int $storeId
     */
    public function __construct($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * {@inheritdoc}
     */
    protected function modify(AbstractImportItem $eventItem)
    {
        /** @var ContentDocument $document */
        $document = $eventItem->getDocument();
        /** @var CmsPageStore $entity */
        $entity = $eventItem->getEntity();

        /** @var CmsPage $page */
        $page = $entity->getPage();

        $document->setId($page->getId());
        $document->setSlug($page->getSlug());
        $document->setTitle($page->getTitle());
        $document->setContent($page->getContent());
        $document->setHeading($page->getHeading());
    }
}
