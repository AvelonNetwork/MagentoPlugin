<?php
/**
 * Avelon Network.
 *
 * NOTICE OF LICENSE
 *

 *
 * @category   Avelon
 * @package    Avelon_AvelonNetwork
 * @author     Avelon
 * @copyright  Copyright (c) Avelon Network ( https://avelonetwork.com/ )
 * @license    https://avelonetwork.com/magento-x-avelon-terms-of-use/
 */
namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Controller\Adminhtml\Settings;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    /**
     * @var \Magento\Backend\App\Action\Context
     */
    private $context;

    /**
     * Index constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Avelon_AvelonNetwork::menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Avelon Settings'));
        return $resultPage;
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Avelon_AvelonNetwork::menu');
    }
}
