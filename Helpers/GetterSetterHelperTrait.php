<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Helpers;

/**
 * Helper class for setters and getters.
 */
trait GetterSetterHelperTrait
{
    /**
     * Removes element from array.
     *
     * @param mixed $element
     * @param mixed $array
     */
    protected function removeElement($element, &$array)
    {
        $key = array_search($element, $array, true);

        if ($key !== false) {
            unset($array[$key]);
        }
    }
}
