# Magento 2 – Customer Address Limits

## Overview

This module provides enhanced customer address management and limitation capabilities for a customer through its plugin-based approach.

![customer_address_limits.png](images%2Fcustomer_address_limits.png)

### Plugins
Harness the power of plugins for advanced functionality:
- [CustomerAddressLimitPlugin.php](Plugin%2FCustomerAddressLimitPlugin.php) — This plugin modifies the behavior of address saving to enforce only 1 non-editable address for a customer.


- [ProhibitAddressDeletionPlugin.php](Plugin%2FProhibitAddressDeletionPlugin.php) — This plugin safeguards customer addresses from deletion, ensuring they remain in customers' accounts once created.


- [ProhibitAddressDeletionGraphQlPlugin.php](Plugin%2FProhibitAddressDeletionGraphQlPlugin.php) — This plugin secures GraphQL customer addresses, preventing their removal after creation by overriding the deletion process.

### Installation

Add the module repository to composer.json:

```
"repositories": [
{"type": "vcs", "url": "git@github.com:IlliaKov/m2-module-customer-address-limits.git"}
]
```

then run the following commands:

```
$ composer require illia-nova/m2-module-customer-address-limits
$ php bin/magento setup:upgrade
```
Author – Illia Nova
