<?php

namespace ONGR\MagentoConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\MagentoConnectorBundle\Entity\CmsPage;
use ONGR\MagentoConnectorBundle\Entity\CmsPageStore;

/**
 * Modifies entities to match ongr content mapping.
 */
class ContentModifier implements ModifierInterface
{
    /**
     * {@inheritdoc}
     */
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        /** @var CmsPage $page */
        $page = $entity->getPage();

        $document->id = $page->getId();
        $document->slug = $page->getSlug();
        $document->title = $page->getTitle();
        $document->content = $this->joinContent($page);
        $document->url = [$page->getSlug() . '/'];
        $document->expired_url = [];
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
