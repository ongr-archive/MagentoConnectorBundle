<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Tests\Unit\Modifier\Helper;

/**
 * Helper trait for modify method tests.
 */
trait ModifierHelperTrait
{
    /**
     * Get array of mocks with set data.
     *
     * @param array  $data   Attribute data.
     *                       Example: [['attributeId' => 3, 'description' => 'value', 'store' => 1]].
     * @param string $entity Entity class name.
     *
     * @return array $attributes
     */
    function getAttributesArray($data, $entity)
    {
        $attributes = [];

        foreach ($data as $attrData) {
            $mock = $this->getMockForAbstractClass($entity);
            $mock->setAttributeId($attrData['attributeId']);
            $mock->setValue($attrData['value']);
            $mock->setStore($attrData['store']);
            $attributes[] = $mock;
        }

        return $attributes;
    }
}
