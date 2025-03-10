<?php

namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Model\ResourceModel\Settings;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Model\Settings',
            'AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\ResourceModel\Settings'
        );
    }
}