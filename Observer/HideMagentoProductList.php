<?php
namespace Tagalys\Frontend\Observer;

class HideMagentoProductList implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Tagalys\Sync\Helper\Configuration
     */
    private $tagalysConfiguration;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        \Magento\Framework\Registry $registry,
        \Tagalys\Sync\Helper\Configuration $tagalysConfiguration,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->tagalysConfiguration = $tagalysConfiguration;
        $this->storeManager = $storeManager;
        $this->registry = $registry;
        $this->category = $this->registry->registry('current_category');
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($observer->getFullActionName() != 'catalog_category_view') {
            return;
        }

        $storeId = $this->storeManager->getStore()->getId();
        $module = "listingpages";
        if(!$this->tagalysConfiguration->isTagalysEnabledForStore($storeId, $module)) {
            return;
        }

        if(!$this->tagalysConfiguration->isJsRenderingEnabledForCategory($storeId, $this->category)) {
            return;
        }
        // store enabled and js rendering on?
        // category is powered by tagalys?
        // Not a CMS page?
        // Tagalys health OK?
        // else return

        // add layout to override category product list
        $observer->getLayout()->getUpdate()->addHandle('tagalys_category_products');
    }
}
