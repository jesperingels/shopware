<?php declare(strict_types=1);

namespace Shopware\Storefront\Page\Account\CustomerGroupRegistration;

use Shopware\Core\Checkout\Customer\Aggregate\CustomerGroup\CustomerGroupEntity;
use Shopware\Core\Framework\Log\Package;
use Shopware\Storefront\Page\Account\Login\AccountLoginPage;

#[Package('checkout')]
class CustomerGroupRegistrationPage extends AccountLoginPage
{
    protected CustomerGroupEntity $customerGroup;

    public function setGroup(CustomerGroupEntity $customerGroup): void
    {
        $this->customerGroup = $customerGroup;
    }

    public function getGroup(): CustomerGroupEntity
    {
        return $this->customerGroup;
    }
}
