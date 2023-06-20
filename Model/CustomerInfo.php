<?php
namespace Dev\Wholesale\Model;

use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;

class CustomerInfo
{
    protected $customerSession;
    protected $customerRepository;

    public function __construct(
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    public function getCustomerId()
    {
        return $this->customerSession->getCustomerId();
    }

    public function getCustomerName()
    {
        $customerId = $this->customerSession->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);
        return $customer->getFirstname() . ' ' . $customer->getLastname();
    }
}
