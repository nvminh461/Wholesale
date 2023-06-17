<?php

namespace Dev\Wholesale\Controller\Adminhtml\Contact;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;

class View extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $_coreRegistry;

    protected $resultPageFactory;

    public function __construct(
        Action\Context                             $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry                $registry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dev_Wholesale::contact_manager');
        return $resultPage;
    }

    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('contact_id');
        $model = $this->_objectManager->create(\Dev\Wholesale\Model\Contact::class);
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This contact no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('contact', $model);

        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Contact Customer'));

        return $resultPage;
    }
}
