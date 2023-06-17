<?php
namespace Dev\Wholesale\Block\Adminhtml\Contact\View;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    protected $context;

    public function __construct(
        Context $context,
    ) {
        $this->context = $context;
    }
    public function getContractId()
    {
        $contractId = $this->context->getRequest()->getParam('contact_id');
        if ($contractId) {
            return $contractId;
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
