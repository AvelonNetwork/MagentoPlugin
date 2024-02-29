<?php

namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Model;

use Magento\Framework\Model\AbstractModel;

class Settings extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Model\ResourceModel\Settings::class);
    }
}