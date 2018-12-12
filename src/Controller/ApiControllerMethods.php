<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ApiControllerMethods
 *
 * @package App\Controller
 */
trait ApiControllerMethods
{

    protected $valid = true;

    /**
     * @var Response
     */
    protected $errorResponse;

    /**
     * Creates and returns an HTTP response
     *
     * @param mixed $data
     * @param int   $status
     *
     * @return Response
     */
    protected function response($data, $status = Response::HTTP_OK): Response
    {
        $data = json_encode($data);
        $response = new Response($data, $status, ['content-type' => 'application/json']);
        return $response;
    }

    /**
     * Parses request content as JSON
     *
     * It validates content type header and, if a list of needed properties is passed, the existence of
     * those properties.
     *
     * @param Request $request
     * @param array   $properties
     *
     * @return mixed|null
     */
    protected function parseRequest(Request $request, array $properties = [])
    {
        if (!$request->headers->contains('content-type', 'application/json')) {
            $this->valid = false;
            $this->errorResponse = $this->badRequest("Invalid content type. Use application/json.");
            return null;
        }

        $data = json_decode($request->getContent());
        foreach ($properties as $property) {
            if (!property_exists($data, $property)) {
                $this->valid = false;
                $this->errorResponse = $this->badRequest(
                    "Missing property '{$property}'. Please verify your request content JSON to include this needed property"
                );
                return null;
            }
        }

        return $data;
    }

    /**
     * Returns a 400 response with provided error message
     *
     * @param string $message
     *
     * @param int $estatus
     * @return Response
     */
    protected function badRequest(string $message, $status = Response::HTTP_BAD_REQUEST): Response
    {
        $response = new Response(
            json_encode([
                'error' => 'Bad request',
                'message' => $message
            ]),
            $status,
            ['content-type' => 'application/json']
        );

        return $response;
    }
}
