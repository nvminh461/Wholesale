<?php

namespace Dev\Wholesale\Controller\Adminhtml\Contact;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Dev\Wholesale\Model\Contact;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Controller\ResultFactory;

class SendMail extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $contact;
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $resultFactory;


    public function __construct(
        Action\Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ResultFactory $resultFactory,
        Contact $contact
    ) {
        $this->contact = $contact;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        // 1. Get ID and create model
        $contactId = $this->getRequest()->getParam('contact_id');
        $contactInfo = $this->contact->load($contactId);

        // 2. Send email
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => 'Smart OSC store',
                'email' => 'mn123733@gmail.com'
            ];
            $recipient = $contactInfo->getCustomer_email(); // Assuming you have an email field in the Contact model
            $message = 'We are delighted that you have contacted us.';
            $message .= "\n\nYour name: " . $contactInfo->getCustomer_name() . "\n";
            $message .= "The product you want to purchase wholesale: " . $contactInfo->getProduct_name() . "\n";
            $message .= "If correct, please confirm the information through this email. Thank you!!!\n";
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('contact_email_wholesale_template') // Replace with your email template identifier
                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_ADMINHTML, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
                ->setTemplateVars(['message' => $message])
                ->setFrom($sender)
                ->addTo($recipient)
                ->getTransport();

            $transport->sendMessage();

            $this->inlineTranslation->resume();

            $contactInfo->setData('status', 1);
            $contactInfo->save();

            $this->messageManager->addSuccess(__('You sent the mail.'));

        } catch (\Exception $e) {
            $this->messageManager->addError(__('An error occurred while sending the email: %1', $e->getMessage()));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
