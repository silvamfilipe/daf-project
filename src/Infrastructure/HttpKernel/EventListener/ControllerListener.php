<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\HttpKernel\EventListener;

use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Domain\UserManagement\UsersRepository;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Zend\Diactoros\Response;

/**
 * Controller Listener
 *
 * @package App\Infrastructure\HttpKernel\EventListener
 */
final class ControllerListener
{
    /**
     * @var ResourceServer
     */
    private $resourceServer;
    /**
     * @var UsersRepository
     */
    private $users;

    /**
     * ControllerListener
     *
     * @param ResourceServer $resourceServer
     * @param UsersRepository $users
     */
    public function __construct(ResourceServer $resourceServer, UsersRepository $users)
    {
        $this->resourceServer = $resourceServer;
        $this->users = $users;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController()[0];
        if (! $controller instanceof AuthenticatedControllerInterface) {
            return null;
        }

        $psr7Factory = new DiactorosFactory();
        $httpFoundationFactory = new HttpFoundationFactory();

        try {
            $request = $this->resourceServer->validateAuthenticatedRequest($psr7Factory->createRequest($event->getRequest()));
            $this->loadUser($request->getAttribute('oauth_user_id', null), $controller);

        } catch (OAuthServerException $e) {
            $event->stopPropagation();
            $response = $e->generateHttpResponse(new Response());
            return $httpFoundationFactory->createResponse($response);
        }

        return null;
    }

    private function loadUser(string $getUserAttribute, AuthenticatedControllerInterface $controller)
    {
    }
}