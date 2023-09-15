<?php

declare(strict_types=1);

namespace IlliaNova\CustomerAddressLimits\Plugin;

use Magento\CustomerGraphQl\Model\Resolver\DeleteCustomerAddress;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use IlliaNova\CustomerAddressLimits\Config\ModuleConfig;

class ProhibitAddressDeletionGraphQlPlugin
{
    private ModuleConfig $moduleConfig;

    public function __construct(
        ModuleConfig $moduleConfig
    ) {
        $this->moduleConfig = $moduleConfig;
    }

    public function beforeResolve(
        DeleteCustomerAddress $subject,
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $storeId = (int) $context->getExtensionAttributes()->getStore()->getId();

        if (!$this->moduleConfig->isEnabled($storeId)) {
            return [$field, $context, $info, $value, $args];
        }

        throw new GraphQlInputException(__('Address deletion is prohibited.'));
    }
}
