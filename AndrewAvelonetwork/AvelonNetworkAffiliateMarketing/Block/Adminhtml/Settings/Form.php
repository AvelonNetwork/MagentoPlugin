<?php

namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Block\Adminhtml\Settings;

use Magento\Backend\Block\Template;
use AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Model\SettingsFactory;
use Psr\Log\LoggerInterface;

class Form extends Template
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

    public function getSettingsData()
    {
        try {
            // Load the settings model
            $settingsModel = $this->settingsFactory->create()->load(1);
            // Check if the settings model exists
            if ($settingsModel->getId()) {
                // Return the settings data
                return $settingsModel->getData();
            } else {
                // If settings model does not exist, return empty array
                return [];
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            $this->_logger->error($e->getMessage());
            // Return empty array if an error occurs
            return [];
        }
    }
}