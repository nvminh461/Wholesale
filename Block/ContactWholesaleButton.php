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

    /**
     * ContactWholesaleButton constructor.
     *
     * @param Template\Context $context
     * @param CustomerSession $customerSession
     * @param ProductFactory $productFactory
     * @param ProductViewBlock $productViewBlock
     * @param ProductRepository $productRepository
     * @param ManagerInterface $messageManager
     * @param UrlInterface $urlInterface
     * @param array $data
     */
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

    /**
     * Get the URL for the wholesale button
     *
     * @return string|null
     */
    public function getButtonUrl()
    {
        if ($this->compareAttributes()) {
            $pathUrl = 'wholesale/index/index/cd';
            return $this->getUrl($pathUrl);
        } else {
            $errorMessage = 'Not eligible to access the path.';
            $this->messageManager->addErrorMessage($errorMessage);
            $currentUrl = $this->urlInterface->getCurrentUrl();
            $this->getResponse()->setRedirect($currentUrl)->sendResponse();
        }
        return null;
    }

    /**
     * Check the wholesale attribute of the customer
     *
     * @return int
     */
    public function checkAttributeCustomer()
    {
        $customerAttribute = '';
        if ($this->customerSession->isLoggedIn()) {
            $customerAttribute = $this->customerSession->getCustomer()->getCusWholesale();
        }
        return $customerAttribute;
    }

    /**
     * Check the wholesale attribute of the product
     *
     * @return int|null
     */
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

    /**
     * Compare the wholesale attributes of the customer and product
     *
     * @return bool
     */
    public function compareAttributes()
    {
        $customerAttribute = $this->checkAttributeCustomer();
        $productAttribute = $this->checkAttributeProduct();

        $compareResult = ($customerAttribute == 1 && $productAttribute == 1);

        return $compareResult;
    }
}
