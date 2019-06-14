<?php
namespace Dilanjan\CustomCatalog\Block\Adminhtml\Product\Edit;

/**
 * Class Tabs
 * @package Dilanjan\CustomCatalog\Block\Adminhtml\Product\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customcatalog_product_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Custom Catalog Edit'));
    }
}
