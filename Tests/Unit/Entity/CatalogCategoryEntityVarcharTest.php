<?php

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Entity;

use ONGR\ConnectionsBundle\Tests\Functional\Entity\AbstractEntityTest;

class CatalogCategoryEntityVarcharTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        return [
            ['id'],
            ['attributeId'],
            ['value'],
            ['category'],
            ['store'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar';
    }
}
