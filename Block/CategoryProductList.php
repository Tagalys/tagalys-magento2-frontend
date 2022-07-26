<?php
namespace Tagalys\Frontend\Block;

class CategoryProductList extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->category = $this->registry->registry('current_category');
        parent::__construct($context, $data);
    }

    public function getCategoryId()
    {
        return $this->category->getId();
    }
}
