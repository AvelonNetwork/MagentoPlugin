<?php

namespace Avelon\AvelonNetwork\Model;

use Magento\Framework\ObjectManagerInterface;

class SettingsFactory
{
    protected $objectManager;
    protected $instanceName;

    public function __construct(ObjectManagerInterface $objectManager, $instanceName = '\\Avelon\\AvelonNetwork\\Model\\Settings')
    {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    public function create(array $arguments = [])
    {
        return $this->objectManager->create($this->instanceName, $arguments);
    }
}