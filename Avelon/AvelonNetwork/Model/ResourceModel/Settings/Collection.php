<?php

namespace Avelon\AvelonNetwork\Model\ResourceModel\Settings;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Avelon/AvelonNetwork\Model\Settings',
            'Avelon/AvelonNetwork\ResourceModel\Settings'
        );
    }
}