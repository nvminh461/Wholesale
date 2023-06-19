<?php

namespace Dev\Wholesale\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ContactActions extends Column
{
    const CONTACT_URL_PATH_VIEW = 'dev_wholesale/contact/view';

    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['contact_id'])) {
                    $item[$name]['view'] = [
                        'href' => $this->urlBuilder->getUrl(self::CONTACT_URL_PATH_VIEW, ['contact_id' => $item['contact_id']]),
                        'label' => __('View')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
