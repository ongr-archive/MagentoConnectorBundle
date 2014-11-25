<?php

namespace ONGR\MagentoConnectorBundle\Provider;

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
        $querySql = 'SELECT e FROM ?1 e
                  WHERE e.storeId = ?2';

        $query = $this->entityManager
            ->createQuery($querySql)
            ->setParameters(
                [
                    1 => $this->entityClass,
                    2 => $this->storeId,
                ]
            );

        return new MemoryEfficientEntitiesIterator(
            $query->iterate(),
            $this->entityManager
        );
    }
}
