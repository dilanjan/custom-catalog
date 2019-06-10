<?php
/**
 * Created by PhpStorm.
 * User: dilanjan
 * Date: 6/8/19
 * Time: 6:43 PM
 */

namespace Dilanjan\CustomCatalog\Ui\DataProvider\Product;

use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFieldToCollectionInterface;

/**
 * Class AddVpnFieldToCollection
 *
 * @package Dilanjan\CustomCatalog\Ui\DataProvider\Product
 */
class AddVpnFieldToCollection implements AddFieldToCollectionInterface
{
    /**
     * Add field to collection reflection
     *
     * @param Collection $collection
     * @param string $field
     * @param string|null $alias
     * @return void
     */
    public function addField(Collection $collection, $field, $alias = null)
    {
        $collection->joinField('vpn', 'catalog_product_entity_varchar', 'vpn', 'product_id=entity_id', null, 'left');
    }
}
