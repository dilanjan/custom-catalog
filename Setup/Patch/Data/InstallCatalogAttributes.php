<?php
/**
 * Created by PhpStorm.
 * User: dilanjan
 * Date: 6/10/19
 * Time: 4:43 PM
 */
namespace Dilanjan\CustomCatalog\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class InstallCatalogAttributes
 *
 * @package Dilanjan\CustomCatalog\Setup\Patch\Data
 */
class InstallCatalogAttributes implements DataPatchInterface
{
    /**
     * constant for attribute group name
     */
    const ATTRIBUTE_GROUP_NAME = 'Custom Catalog';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * AddSizeChartProductAttribute constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param EavConfig $eavConfig
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        EavConfig $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * Example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - than under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     *
     * @return void
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            'vpn',
            [
                'type' => 'varchar',
                'label' => 'Vendor Product Number',
                'input' => 'text',
                'sort_order' => 50,
                'global' => Attribute::SCOPE_GLOBAL,
                'user_defined' => true,
                'required' => false,
                'used_in_product_listing' => false,
                'apply_to' => '',
                'group' => self::ATTRIBUTE_GROUP_NAME,
                'note' => 'Vendor Product Number',
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
            ]
        );

        $eavSetup->addAttribute(
            Product::ENTITY,
            'copy_write_information',
            [
                'type' => 'text',
                'label' => 'Copy Write Information',
                'input' => 'textarea',
                'wysiwyg_enabled' => true,
                'is_html_allowed_on_front' => true,
                'sort_order' => 60,
                'required' => false,
                'user_defined' => true,
                'searchable' => false,
                'position' => 60,
                'filterable' => false,
                'filterable_in_search' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_for_sort_by' => false,
                'used_in_product_listing' => true,
                'global' => Attribute::SCOPE_STORE,
                'apply_to' => '',
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'group' => self::ATTRIBUTE_GROUP_NAME,
                'note' => 'Copy Write Information',
            ]
        );
    }
}
