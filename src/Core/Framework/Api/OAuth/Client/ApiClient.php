<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Api\OAuth\Client;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use Shopware\Core\Framework\Log\Package;

#[Package('framework')]
class ApiClient implements ClientEntityInterface
{
    use ClientTrait;

    /**
     * @param non-empty-string $identifier
     */
    public function __construct(
        private readonly string $identifier,
        private readonly bool $writeAccess,
        string $name = ''
    ) {
        $this->name = $name;
    }

    public function getWriteAccess(): bool
    {
        return $this->writeAccess;
    }

    /**
     * @return non-empty-string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function isConfidential(): bool
    {
        return true;
    }
}
