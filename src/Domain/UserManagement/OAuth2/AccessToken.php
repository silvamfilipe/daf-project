<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\UserManagement\OAuth2;

use DateTime;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use Ramsey\Uuid\Uuid;

/**
 * AccessToken
 *
 * @package App\Domain\UserManagement\OAuth2
 */
class AccessToken implements AccessTokenEntityInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var ScopeEntityInterface[]
     */
    protected $scopes = [];

    /**
     * @var DateTime
     */
    protected $expiryDateTime;

    /**
     * @var string|int|null
     */
    protected $userIdentifier;

    /**
     * @var ClientEntityInterface
     */
    protected $client;

    use EntityTrait, TokenEntityTrait, AccessTokenTrait;

    /**
     * Creates a AccessToken
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->identifier = Uuid::uuid4()->toString();
    }
}
