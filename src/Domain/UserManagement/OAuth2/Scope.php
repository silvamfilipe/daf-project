<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\UserManagement\OAuth2;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Scope
 *
 * @package App\Domain\UserManagement\OAuth2
 */
class Scope implements ScopeEntityInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $description;

    /**
     * Creates a Scope
     *
     * @param string $identifier
     * @param string $description
     */
    public function __construct(string $identifier, string $description)
    {
        $this->identifier = $identifier;
        $this->description = $description;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

    public function description(): string
    {
        return $this->description;
    }

    /**
     * Get the scope's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Serialize the object to the scopes string identifier when using json_encode().
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getIdentifier();
    }
}
