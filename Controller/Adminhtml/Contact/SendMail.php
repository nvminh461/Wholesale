<?php

namespace Dev\Wholesale\Controller\Adminhtml\Contact;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Dev\Wholesale\Model\Contact;

class SendMail extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $contact;

    public function __construct(
        Action\Context $context,
        Contact $contact
    ) {
        $this->contact = $contact;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        // 1. Get ID and create model
        $contactId = $this->getRequest()->getParam('contact_id');
        $contactInfo = $this->contact->load($contactId);
        $contactInfo->setData('status', 1);
        $contactInfo->save();
        $this->messageManager->addSuccess(__('You sent the mail.'));

        return $resultRedirect->setPath('*/*/');
    }
}
