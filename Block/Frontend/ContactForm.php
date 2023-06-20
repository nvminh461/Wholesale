<?php
namespace Dev\Wholesale\Block\Frontend;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template;

class ContactForm extends Template
{
    protected $customerSession;
    protected $customerRepository;

    public function __construct(
        Template\Context $context,
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    public function isLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    public function getCurrentCustomer(){
        if($this->isLoggedIn()){
            return $this->customerSession->getCustomer();
        }
        return null;
    }
}
