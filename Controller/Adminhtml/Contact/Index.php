<?php

namespace Dev\Wholesale\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action;

class Index extends Action
{

    protected $resultPageFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }


    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dev_Wholesale::contact_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Contact Manager'));

        return $resultPage;
    }
}
