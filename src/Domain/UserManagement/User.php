<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\UserManagement;

use App\Domain\UserManagement\User\Email;
use App\Domain\UserManagement\User\Password;
use App\Domain\UserManagement\User\UserId;
use JsonSerializable;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * User
 *
 * @package App\Domain\UserManagement
 */
class User implements UserEntityInterface, JsonSerializable
{

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var Password
     */
    private $password;

    /**
     * Creates an User
     *
     * @param string        $name
     * @param Email         $email
     * @param Password|null $password
     *
     * @throws \Exception
     */
    public function __construct(string $name, Email $email, Password $password = null)
    {
        $this->userId = new UserId();
        $this->name = $name;
        $this->email = $email;
        $this->password = $password ?: new Password();
    }

    /**
     * User's internal ID
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * User's full name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * User's email address
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * User's password
     *
     * @return Password
     */
    public function password(): Password
    {
        return $this->password;
    }

    /**
     * Change user password
     *
     * @param Password $password
     *
     * @return User
     */
    public function changePassword(Password $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Updates user's name and/or e-mail address
     *
     * @param string $name
     * @param Email  $email
     *
     * @return User
     */
    public function updateInfo(string $name, Email $email): User
    {
        $this->name = $name;
        $this->email = $email;
        return $this;
    }

    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->userId;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by json_encode(),
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'userId' => $this->userId,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
