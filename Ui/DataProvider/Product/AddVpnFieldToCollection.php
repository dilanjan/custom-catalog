<?php
/**
 * Created by PhpStorm.
 * User: dilanjan
 * Date: 6/8/19
 * Time: 6:43 PM
 */

namespace Dilanjan\CustomCatalog\Ui\DataProvider\Product;

use Magento\Catalog\Model\Product;
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
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute
     */
    private $eavAttribute;

    /**
     * AddVpnFieldToCollection constructor.
     *
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute
    ) {
        $this->eavAttribute = $eavAttribute;
    }

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
        $attributeId = $this->eavAttribute->getIdByCode(Product::ENTITY, 'vpn');
        $collection->joinField('vpn', 'catalog_product_entity_varchar', 'vpn', 'product_id=entity_id', null, 'left');
    }
}
