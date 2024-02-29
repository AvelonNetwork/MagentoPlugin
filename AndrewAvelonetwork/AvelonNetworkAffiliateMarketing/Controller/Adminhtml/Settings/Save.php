<?php

namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Controller\Adminhtml\Settings;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Model\SettingsFactory;
use AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Service\AvlnCacheManager;

class Save extends Action
{
    protected $settingsFactory;

    public function __construct(
        Context $context,
        SettingsFactory $settingsFactory,
        AvlnCacheManager $avlnCacheManager
    ) {
        parent::__construct($context);
        $this->settingsFactory = $settingsFactory;
        $this->avlnCacheManager = $avlnCacheManager;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            try {
                $settingsModel = $this->settingsFactory->create()->load(1);
                if (!$settingsModel->getId()) {
                    $settingsModel = $this->settingsFactory->create();
                }
                $settingsModel->addData($data);
                $settingsModel->save();
                $this->messageManager->addSuccessMessage(__('Settings have been saved.'));
                // Clean cache after saving settings
                $this->avlnCacheManager->cleanCache();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error occurred while saving settings: %1', $e->getMessage()));
            }
        }
        $returnUrl = $this->getRequest()->getParam('return_url', '*/*/');
        return $this->_redirect($returnUrl);
    }
}