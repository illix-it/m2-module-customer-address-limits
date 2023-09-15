<?php

declare(strict_types=1);

namespace IlliaNova\CustomerAddressLimits\Plugin;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use IlliaNova\CustomerAddressLimits\Config\ModuleConfig;

class ProhibitAddressDeletionPlugin
{
    private ModuleConfig $moduleConfig;
    private StoreManagerInterface $storeManager;

    public function __construct(
        ModuleConfig $moduleConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->storeManager = $storeManager;
    }

    public function beforeDeleteById(AddressRepositoryInterface $subject, $addressId): array
    {
        $storeId = (int) $this->storeManager->getStore()->getId();

        if (!$this->moduleConfig->isEnabled($storeId)) {
            return [$addressId];
        }

        throw new LocalizedException(__('Address deletion is prohibited.'));
    }
}
