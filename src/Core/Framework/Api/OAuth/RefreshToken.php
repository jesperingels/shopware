<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Api\OAuth;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Shopware\Core\Framework\Log\Package;

#[Package('framework')]
class RefreshToken implements RefreshTokenEntityInterface
{
    use EntityTrait;
    use RefreshTokenTrait;
}
