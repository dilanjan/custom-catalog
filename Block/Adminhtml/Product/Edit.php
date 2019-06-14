<?php
namespace Dilanjan\CustomCatalog\Block\Adminhtml\Product;

/**
 * Class Edit
 * @package Dilanjan\CustomCatalog\Block\Adminhtml\Product
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry = null;

    /**
     * Edit constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ){
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId   = 'product_id';
        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'Dilanjan_CustomCatalog';

        parent::_construct();

        $this->buttonList->add(
            'save_and_continue_edit',
            [
                'class' => 'save',
                'label' => __('Save and Continue Edit'),
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
                ]
            ],
            10
        );
    }

    public function getHeaderText()
    {
        $product = $this->_coreRegistry->registry('current_product');
        if ($product->getId()) {
            return __("Edit Product '%1'", $this->escapeHtml($product->getName()));
        } else {
            return __('New Product');
        }
    }
}
