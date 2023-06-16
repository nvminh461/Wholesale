<?php

namespace Dev\Wholesale\Ui\Component\Listing\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;


class ViewActions extends Column
{
    const CMS_URL_PATH_EDIT = 'dev_banner/banner/edit';
    const CMS_URL_PATH_DELETE = 'dev_banner/banner/delete';

    protected $urlBuilder;
    private $editUrl;
    private $escaper;

    public function __construct(
        ContextInterface                            $context,
        UiComponentFactory                          $uiComponentFactory,
        UrlInterface                                $urlBuilder,
        array                                       $components = [],
        array                                       $data = [],
                                                    $editUrl = self::CMS_URL_PATH_EDIT,
        \Magento\Cms\ViewModel\Page\Grid\UrlBuilder $scopeUrlBuilder = null
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->scopeUrlBuilder = $scopeUrlBuilder ?: ObjectManager::getInstance()
            ->get(\Magento\Cms\ViewModel\Page\Grid\UrlBuilder::class);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['banner_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['banner_id' => $item['banner_id']]),
                        'label' => __('Edit'),
                    ];
                    $title = $this->getEscaper()->escapeHtml($item['name']);
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::CMS_URL_PATH_DELETE, ['banner_id' => $item['banner_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete a banner'),
                            'message' => __('Are you sure you want to delete a banner ?', $title),
                        ],
                        'post' => true,
                    ];
                }
            }
        }
        return $dataSource;
    }

    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}
