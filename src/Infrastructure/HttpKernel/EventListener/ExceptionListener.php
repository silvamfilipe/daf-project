<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\HttpKernel\EventListener;

use App\Infrastructure\HttpKernel\Oauth2Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * ExceptionListener
 *
 * @package App\Infrastructure\HttpKernel\EventListener
 */
final class ExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof Oauth2Exception) {
            $event->setResponse($exception->response());
            return;
        }

        $response = new Response(
            json_encode([
                'error' => 'Internal server error',
                'message' => $exception->getMessage()
            ]),
            Response::HTTP_INTERNAL_SERVER_ERROR,
            ['content-type' => 'application/json']
        );

        $event->setResponse($response);
    }
}