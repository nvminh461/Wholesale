<?php
namespace Dev\Wholesale\Model;

use Magento\Customer\Model\Customer;

class WholesaleCustomer extends Customer
{
    /**
     * Check if the customer is a wholesale customer.
     *
     * @return bool
     */
    public function isWholesaleCustomer()
    {
        return $this->getCustomAttribute('cus_wholesale')->getValue() === '1';
    }
}
