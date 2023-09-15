<?php

declare(strict_types=1);

namespace IlliaNova\CustomerAddressLimits\Plugin;

use Magento\Framework\Exception\InputException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use IlliaNova\CustomerAddressLimits\Config\ModuleConfig;

class CustomerAddressLimitPlugin
{
    private StoreManagerInterface $storeManager;
    private ModuleConfig $moduleConfig;
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(
        StoreManagerInterface $storeManager,
        ModuleConfig $moduleConfig,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->storeManager       = $storeManager;
        $this->moduleConfig       = $moduleConfig;
        $this->customerRepository = $customerRepository;
    }

    public function beforeSave(
        AddressRepositoryInterface $subject,
        AddressInterface $address
    ): array {
        $storeId = (int) $this->storeManager->getStore()->getId();

        if (!$this->moduleConfig->isEnabled($storeId)) {
            return [$address];
        }

        $customerId = $address->getCustomerId();

        if (!$customerId) {
            return [$address];
        }

        $customer          = $this->customerRepository->getById($customerId);
        $customerAddresses = $customer->getAddresses() ?? [];

        if (count($customerAddresses) >= 1) {
            throw new InputException(__('You have reached the maximum address limit.'));
        }

        return [$address];
    }
}
