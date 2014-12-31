<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\MagentoConnectorBundle\Documents\ContentDocument;
use ONGR\MagentoConnectorBundle\Entity\CmsPage;

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
        /** @var CmsPage $entity */
        $entity = $eventItem->getEntity();

        $this->transform($document, $entity);
    }

    /**
     * Assigns data to given document.
     *
     * @param ContentDocument $document
     * @param CmsPage         $entity
     */
    protected function transform(ContentDocument $document, CmsPage $entity)
    {
        $document->setId($entity->getId());
        $document->setSlug($entity->getSlug());
        $document->setTitle($entity->getTitle());
        $document->setContent($entity->getContent());
        $document->setHeading($entity->getHeading());
    }
}
