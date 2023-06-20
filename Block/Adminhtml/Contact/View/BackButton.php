<?php
namespace Dev\Wholesale\Block\Adminhtml\Contact\View;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'), // Nhãn của nút
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()), // Xử lý khi nút được nhấp
            'class' => 'back', // Lớp CSS cho nút
            'sort_order' => 10 // Thứ tự sắp xếp của nút
        ];
    }

    /**
     * Get the URL for the Back button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/'); // URL cho nút Back
    }
}
