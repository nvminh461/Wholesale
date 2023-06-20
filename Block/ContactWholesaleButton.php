<?php

namespace Dev\Wholesale\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Block\Product\View as ProductViewBlock;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;

class ContactWholesaleButton extends Template
{
    protected $customerSession;
    protected $productFactory;
    protected $productViewBlock;
    protected $productRepository;
    protected $messageManager;
    protected $urlInterface;

    public function __construct(
        Template\Context  $context,
        CustomerSession   $customerSession,
        ProductFactory    $productFactory,
        ProductViewBlock  $productViewBlock,
        ProductRepository $productRepository,
        ManagerInterface  $messageManager,
        UrlInterface      $urlInterface,
        array             $data = []
    )
    {
        $this->customerSession = $customerSession;
        $this->productFactory = $productFactory;
        $this->productViewBlock = $productViewBlock;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        $this->urlInterface = $urlInterface;
        parent::__construct($context, $data);
    }

    public function getButtonUrl()
    {
        if ($this->compareAttributes()) {
            $pathUrl = 'admin/dev_wholesale/contact/';
            return $this->getUrl($pathUrl);
        } else {
            $errorMessage = 'Not eligible to access the path.';
            $this->messageManager->addErrorMessage($errorMessage);
            $currentUrl = $this->urlInterface->getCurrentUrl();
            $this->getResponse()->setRedirect($currentUrl)->sendResponse();
        }
        return null;
    }

    public function checkAttributeCustomer()
    {
        $customerAttribute = '';
        if ($this->customerSession->isLoggedIn()) {
            $customerAttribute = $this->customerSession->getCustomer()->getCusWholesale();
        }
        return $customerAttribute;
    }

    public function checkAttributeProduct()
    {
        $productId = $this->productViewBlock->getProduct()->getId();
        try {
            $product = $this->productRepository->getById($productId);
            $pro_wholesale = $product->getData('pro_wholesale');
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
        return $pro_wholesale;
    }

    public function compareAttributes()
    {
        $customerAttribute = $this->checkAttributeCustomer();
        $productAttribute = $this->checkAttributeProduct();

        $compareResult = ($customerAttribute == 1 && $productAttribute == 1);

        return $compareResult;
    }
}
