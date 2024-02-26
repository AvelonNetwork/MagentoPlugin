<?php

namespace Avelon\AvelonNetwork\Model;

use Magento\Framework\Model\AbstractModel;

class Settings extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Avelon\AvelonNetwork\Model\ResourceModel\Settings::class);
    }
}