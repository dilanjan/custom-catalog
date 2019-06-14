<?php

namespace Dilanjan\CustomCatalog\Block\Adminhtml\Product\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;

/**
 * Class EditInfo
 * @package Dilanjan\CustomCatalog\Block\Adminhtml\Product\Edit\Tab
 */
class EditInfo extends Generic implements TabInterface
{
    protected $_wysiwygConfig;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * CustomCatalogs constructor.
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        array $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
        $this->registry = $registry;
    }

    public function getTabLabel()
    {
        return __('Add CustomCatalog');
    }

    public function getTabTitle()
    {
        return __('Add CustomCatalog');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    /**
     * @return Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_product');

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('ps_product_');

        $fieldset = $form->addFieldset('ps_product_fieldset', ['legend' => __('Product')]);

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'id']);
            $fieldset->addField('type_id', 'hidden', ['name' => 'type']);
        }

        $fieldset->addField(
            'name',
            'text',
            ['name' => 'product_name', 'label' => __('Product Name'), 'title' => __('Product Name'), 'disabled' => true]
        );

        $fieldset->addField(
            'sku',
            'text',
            ['name' => 'product_sku', 'label' => __('SKU'), 'title' => __('SKU'), 'disabled' => true]
        );

        $fieldset->addField(
            'store_id',
            'hidden',
            ['name' => 'store', 'value' => $this->_storeManager->getStore(true)->getId()]
        );

        $fieldset->addField(
            'vpn',
            'text',
            [
                'name' => 'vpn',
                'label' => __('Vendor Product Number'),
                'title' => __('Vendor Product Number'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'copy_write_information',
            'text',
            [
                'name' => 'copy_write_information',
                'label' => __('Copy Write Information'),
                'title' => __('Copy Write Information'),
                'required' => false
            ]
        );

        $model->setStoreId($this->_storeManager->getStore(true)->getId());

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
