<?php
namespace Dilanjan\CustomCatalog\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\View\LayoutFactory;
use \Magento\Framework\View\Result\LayoutFactory as ResultLayoutFactory;

/**
 * Class CustomCatalog
 * @package Dilanjan\CustomCatalog\Controller\Adminhtml
 */
abstract class CustomCatalog extends Action
{
    /**
     * @var Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @var FileFactory
     */
    protected $_fileFactory;

    /**
     * @var
     */
    protected $_viewHelper;

    /**
     * @var ResultLayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * CustomCatalog constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FileFactory $fileFactory
     * @param LayoutFactory $layoutFactory
     * @param ResultLayoutFactory $resultLayoutFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FileFactory $fileFactory,
        LayoutFactory $layoutFactory,
        ResultLayoutFactory $resultLayoutFactory,
        PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->layoutFactory = $layoutFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return $this
     */
    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Magento_Catalog::inventory');
        return $this;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dilanjan_CustomCatalog::custom_catalog');
    }
}
