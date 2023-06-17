<?php

namespace Dev\Wholesale\Model;

class Status extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_SENT = 1;
    const STATUS_UNSENT = 0;

    protected function _construct()
    {
        $this->_init('Dev\Wholesale\Model\ResourceModel\Contact');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_SENT => __('Sent'), self::STATUS_UNSENT => __('Unsent')];
    }

}
