<?php

namespace ONGR\MagentoConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\Event\AbstractInitialSyncModifyEvent;
use ONGR\ConnectionsBundle\Event\ImportItem;
use ONGR\MagentoConnectorBundle\Documents\ContentDocument;
use ONGR\MagentoConnectorBundle\Entity\CmsPage;
use ONGR\MagentoConnectorBundle\Entity\CmsPageStore;

/**
 * Modifies entities to match ongr content mapping.
 */
class ContentModifier extends AbstractInitialSyncModifyEvent
{
    /**
     * {@inheritdoc}
     */
    protected function modify(ImportItem $eventItem)
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
        $document->setContent($this->joinContent($page));
        //$document->addUrlString();
    }

    /**
     * Joins heading with content, if heading is present.
     *
     * @param CmsPage $entity
     *
     * @return string
     */
    public function joinContent($entity)
    {
        if ($entity->getHeading()) {
            return '<h1>' . $entity->getHeading() . '</h1>' . $entity->getContent();
        } else {
            return $entity->getContent();
        }
    }
}
