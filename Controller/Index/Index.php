<?php

namespace Tagalys\Frontend\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    /**
     * @param \Tagalys\Sync\Helper\Configuration
     */
    private $tagalysConfiguration;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Page\Config $pageConfig,
        \Tagalys\Sync\Helper\Configuration $tagalysConfiguration
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->pageConfig = $pageConfig;
        $this->tagalysConfiguration = $tagalysConfiguration;
        $this->request = $context->getRequest();
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $params = $this->request->getParams();
        $resultPage->getConfig()->getTitle()->set('Search Results for "' . $params['q'] . '"');

        $this->pageConfig->setRobots('NOINDEX,NOFOLLOW');

        $customLayoutName = $this->tagalysConfiguration->getConfig('search:override_layout_name');
        if(!empty($customLayoutName)) {
            $resultPage->getConfig()->setPageLayout($customLayoutName);
        }

        return $resultPage;
    }
}