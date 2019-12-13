<?php
 
namespace Tagalys\Search\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Page\Config $pageConfig
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->pageConfig = $pageConfig;
        $this->request = $context->getRequest();
        parent::__construct($context);
    }
 
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $params = $this->request->getParams();
        $resultPage->getConfig()->getTitle()->set('Search Results for "' . $params['q'] . '"');

        $this->pageConfig->setRobots('NOINDEX,NOFOLLOW');

        return $resultPage;
    }
}