<?php

namespace Avelon\AvelonNetwork\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Settings extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('avelon_settings', 'id');
    }
}