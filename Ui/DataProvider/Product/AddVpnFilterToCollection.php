<?php
/**
 * Created by PhpStorm.
 * User: dilanjan
 * Date: 6/8/19
 * Time: 6:43 PM
 */

namespace Dilanjan\CustomCatalog\Ui\DataProvider\Product;

use Magento\Framework\Data\Collection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;

/**
 * Class AddVpnFilterToCollection
 *
 * @package Dilanjan\CustomCatalog\Ui\DataProvider\Product
 */
class AddVpnFilterToCollection implements AddFilterToCollectionInterface
{
    /**
     * Add filter
     *
     * @param Collection $collection
     * @param string $field
     * @param void $condition
     * @throws LocalizedException
     */
    public function addFilter(Collection $collection, $field, $condition = null)
    {
        if (isset($condition['eq'])) {
            $collection->addFieldToFilter($field, $condition);
        }
    }
}

