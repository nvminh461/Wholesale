<?php
namespace Dev\Wholesale\Block;

use Magento\Framework\View\Element\Template;

class ContactWholesaleButton extends Template
{
    public function getButtonUrl()
    {

        // Xử lý logic để trả về URL cho việc xử lý sự kiện của nút "Contact for Wholesale"
        return $this->getUrl('admin/Dev_Wholesale/contact/index/');
    }
}
