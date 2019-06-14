<?php
namespace Dilanjan\CustomCatalog\Controller\Adminhtml\Product;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class Save
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Product implements HttpPostActionInterface
{
    /**
     * @var Initialization\Helper
     */
    protected $initializationHelper;

    /**
     * @var \Magento\Catalog\Model\Product\Copier
     */
    protected $productCopier;

    /**
     * @var \Magento\Catalog\Model\Product\TypeTransitionManager
     */
    protected $productTypeManager;

    /**
     * @var \Magento\Catalog\Api\CategoryLinkManagementInterface
     */
    protected $categoryLinkManagement;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Magento\Framework\Escaper|null
     */
    private $escaper;

    /**
     * @var null|\Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param Product\Builder $productBuilder
     * @param Product\Initialization\Helper $initializationHelper
     * @param \Magento\Catalog\Model\Product\Copier $productCopier
     * @param \Magento\Catalog\Model\Product\TypeTransitionManager $productTypeManager
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Escaper|null $escaper
     * @param \Psr\Log\LoggerInterface|null $logger
     */
    public function __construct(
        Action\Context $context,
        Product\Builder $productBuilder,
        Product\Initialization\Helper $initializationHelper,
        \Magento\Catalog\Model\Product\Copier $productCopier,
        \Magento\Catalog\Model\Product\TypeTransitionManager $productTypeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Escaper $escaper = null,
        \Psr\Log\LoggerInterface $logger = null
    ) {
        $this->initializationHelper = $initializationHelper;
        $this->productCopier = $productCopier;
        $this->productTypeManager = $productTypeManager;
        $this->productRepository = $productRepository;
        parent::__construct($context, $productBuilder);
        $this->escaper = $escaper ?? $this->_objectManager->get(\Magento\Framework\Escaper::class);
        $this->logger = $logger ?? $this->_objectManager->get(\Psr\Log\LoggerInterface::class);
    }

    /**
     * Save product action
     *
     * @return void|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $saveErrors = false;

                $product = $this->initializationHelper->initialize(
                    $this->productBuilder->build($this->getRequest())
                );

                $product->addData([
                    'vpn' => $this->getRequest()->getParam('vpn'),
                    'copy_write_information' => $this->getRequest()->getParam('copy_write_information')
                ]);

                $product->save();

                if($saveErrors != false){
                    $this->messageManager->addSuccess(__('You saved Custom Catalog data.'));
                }

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('customcatalog/product/edit', ['id' => $this->getRequest()->getParam('entity_id')]);
                    return;
                }

                $this->_redirect('customcatalog/product/index');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());

                $id = (int) $this->getRequest()->getParam('entity_id');

                if (!empty($id)) {
                    $this->_redirect('customcatalog/product/edit', ['id' => $id]);
                } else {
                    $this->_redirect('customcatalog/product/index');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the product data. Please review the error log.')
                );
                $this->logger->critical($e);
                $this->_redirect('customcatalog/product/edit', ['id' => $this->getRequest()->getParam('entity_id')]);
                return;
            }
        }
        $this->_redirect('customcatalog/product/index');
    }
}
