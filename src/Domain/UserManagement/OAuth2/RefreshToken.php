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
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Ramsey\Uuid\Uuid;

/**
 * RefreshToken
 *
 * @package App\Domain\UserManagement\OAuth2
 */
class RefreshToken implements RefreshTokenEntityInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var AccessTokenEntityInterface
     */
    protected $accessToken;

    /**
     * @var DateTime
     */
    protected $expiryDateTime;

    use EntityTrait, RefreshTokenTrait;

    /**
     * Creates a RefreshToken
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->identifier = Uuid::uuid4()->toString();
    }
}
