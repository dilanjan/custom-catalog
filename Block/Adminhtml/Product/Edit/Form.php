<?php

namespace Dilanjan\CustomCatalog\Block\Adminhtml\Product\Edit;

/**
 * Class Form
 * @package Dilanjan\CustomCatalog\Block\Adminhtml\Product\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customcatalog_product_form');
        $this->setTitle(__('Product Information'));
    }

    /**
     * @return \Magento\Backend\Block\Widget\Form\Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('customcatalog/product/save'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ],
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
