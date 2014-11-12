<?php

namespace ONGR\MagentoConnectorBundle\Provider;

use Doctrine\ORM\EntityManager;
use ONGR\ConnectionsBundle\Doctrine\Iterator\MemoryEfficientEntitiesIterator;
use ONGR\ConnectionsBundle\Doctrine\Provider\Provider;

/**
 * Data provider for ContentModifier.
 */
class ContentProvider extends Provider
{
    /**
     * @var int
     */
    protected $storeId;

    /**
     * @param int $storeId
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllEntities()
    {
        $query = sprintf('SELECT e FROM %s e', $this->entityClass);
        $query .= sprintf(' WHERE e.storeId=%d', $this->storeId);

        return new MemoryEfficientEntitiesIterator(
            $this->entityManager->createQuery($query)->iterate(),
            $this->entityManager
        );
    }
}
