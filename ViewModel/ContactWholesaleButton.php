<?php
namespace Dev\Wholesale\ViewModel;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ContactWholesaleButton implements ArgumentInterface
{
    protected $customerSession;

    public function __construct(
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    public function getCustomerId()
    {
        return $this->customerSession->getCustomerId();
    }

    public function getCustomerName()
    {
        return $this->customerSession->getCustomer()->getName();
    }
}
