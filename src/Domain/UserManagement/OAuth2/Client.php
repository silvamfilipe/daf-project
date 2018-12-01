<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\UserManagement\OAuth2;

use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * Client
 *
 * @package App\Domain\UserManagement\OAuth2
 */
class Client implements ClientEntityInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $secret;

    /**
     * @var array
     */
    private $redirectUri;

    /**
     * Creates a Client
     *
     * @param string       $identifier
     * @param string       $name
     * @param string|null  $secret
     * @param array|string $redirectUri
     *
     * @throws \Exception
     */
    public function __construct(string $identifier, string $name, string $secret = null, $redirectUri = [])
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->secret = $secret ?: bin2hex(random_bytes(16));
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function secret(): string
    {
        return $this->secret;
    }

    /**
     * @return array|string
     */
    public function redirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }
}
