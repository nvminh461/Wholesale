<?php
namespace Dev\Wholesale\Block\Adminhtml\Contact\View;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SendMail extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Send Mail'),
            'on_click' => sprintf("location.href = '%s';", $this->SendMailUrl()),
            'class' => 'save primary',
            'sort_order' => 20
        ];
    }

    public function SendMailUrl()
    {
        return $this->getUrl('*/*/sendmail');
    }
}
