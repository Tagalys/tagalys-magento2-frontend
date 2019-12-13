<?php
namespace Tagalys\Frontend\Block;
 
class Tsearch extends \Magento\Framework\View\Element\Template
{
    public function __construct(
      \Magento\Framework\View\Element\Template\Context $context
      // \Tagalys\Sync\Helper\Configuration $configurationHelper
    )
    {
        // $this->productHelper = $productHelper;
        // $this->configurationHelper = $configurationHelper;
        // $this->request = $request;
        // $this->configCollectionFactory = $configCollectionFactory;
        // $this->configFactory = $configFactory;
        parent::__construct($context);
    }

}