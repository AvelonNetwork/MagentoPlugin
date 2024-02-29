<?php

namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Block;

use Magento\Framework\View\Element\Template;
use AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Model\SettingsFactory;

class AddAvelonScript extends Template
{
    protected $settingsFactory;

    public function __construct(
        Template\Context $context,
        SettingsFactory $settingsFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->settingsFactory = $settingsFactory;
    }

    public function getAvelonAccountId()
    {
        return $this->getSettingValue('avelon_account_id');
    }

    public function getAvelonApiToken()
    {
        return $this->getSettingValue('avelon_api_token');
    }

    protected function getSettingValue($field)
    {
        try {
            // Load the settings model
            $settingsModel = $this->settingsFactory->create()->load(1);
            // Check if the settings model exists
            if ($settingsModel->getId()) {
                // Return the specified field value
                return $settingsModel->getData($field);
            } else {
                // If settings model does not exist, return an empty string or handle as needed
                return '';
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            $this->_logger->error($e->getMessage());
            // Return an empty string or handle as needed
            return '';
        }
    }
}
