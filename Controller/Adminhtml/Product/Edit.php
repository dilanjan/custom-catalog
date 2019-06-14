<?php
namespace Dilanjan\CustomCatalog\Controller\Adminhtml\Product;

use Dilanjan\CustomCatalog\Controller\Adminhtml\CustomCatalog;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\Result\LayoutFactory as ResultLayoutFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 * @package Dilanjan\CustomCatalog\Controller\Adminhtml\Product
 */
class Edit extends CustomCatalog
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var \Magento\Catalog\Controller\Adminhtml\Product\Builder
     */
    protected $productBuilder;
    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * Edit constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FileFactory $fileFactory
     * @param LayoutFactory $layoutFactory
     * @param ResultLayoutFactory $resultLayoutFactory
     * @param PageFactory $resultPageFactory
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder
     * @param \Magento\Backend\Model\Session $session
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FileFactory $fileFactory,
        LayoutFactory $layoutFactory,
        ResultLayoutFactory $resultLayoutFactory,
        PageFactory $resultPageFactory,
        \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder,
        \Magento\Backend\Model\Session $session
    ) {
        parent::__construct(
            $context,
            $coreRegistry,
            $fileFactory,
            $layoutFactory,
            $resultLayoutFactory,
            $resultPageFactory
        );
        $this->session = $session;
        $this->productBuilder = $productBuilder;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
        $storeManager = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class);
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        $store = $storeManager->getStore($storeId);
        $storeManager->setCurrentStore($store->getCode());
        $productId = (int) $this->getRequest()->getParam('id');
        $product = $this->productBuilder->build($this->getRequest());

        if (($productId && !$product->getEntityId())) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('This product doesn\'t exist.'));
            return $resultRedirect->setPath('customcatalog/*/');
        } elseif ($productId === 0) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('Invalid product id. Should be numeric value greater than 0'));
            return $resultRedirect->setPath('customcatalog/*/');
        }

        $this->_eventManager->dispatch('catalog_product_edit_action', ['product' => $product]);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addHandle('catalog_product_' . $product->getTypeId());
        $resultPage->setActiveMenu('Magento_Catalog::catalog_products');
        $resultPage->getConfig()->getTitle()->prepend(__('Products'));
        $resultPage->getConfig()->getTitle()->prepend($product->getName());

        if (!$this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->isSingleStoreMode()
            &&
            ($switchBlock = $resultPage->getLayout()->getBlock('store_switcher'))
        ) {
            $switchBlock->setDefaultStoreName(__('Default Values'))
                ->setWebsiteIds($product->getWebsiteIds())
                ->setSwitchUrl(
                    $this->getUrl(
                        'customcatalog/*/*',
                        ['_current' => true, 'active_tab' => null, 'tab' => null, 'store' => null]
                    )
                );
        }

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dilanjan_CustomCatalog::custom_catalog');
    }
}