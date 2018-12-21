<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\AnswersQuery;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MyAnswersController
 *
 * @package App\Controller\QuestionManagement\Answer
 */
final class MyAnswersController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var AnswersQuery
     */
    private $answersQuery;

    /**
     * Creates a MyAnswersController
     *
     * @param AnswersQuery $answersQuery
     */
    public function __construct(AnswersQuery $answersQuery)
    {
        $this->answersQuery = $answersQuery;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/my/answers", methods={"GET"})
     */
    public function myList(Request $request): Response
    {
        $attributes = $request->query->all();
        $attributes['userId'] = (string) $this->currentUser()->userId();
        return $this->response($this->answersQuery->data($attributes));
    }
}


/**
 * @OA\Get(
 *     path="/my/answers",
 *     tags={"Answers"},
 *     summary="Returns a list of answers",
 *     description="Returns a paginated list of my answers",
 *     operationId="getMyAnswers",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="current pagination page",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="rows",
 *         in="query",
 *         description="Number of rows per page",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="pattern",
 *         in="query",
 *         description="Filters result with a search pattern",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="A list of user answers",
 *         @OA\JsonContent(ref="#/components/schemas/AnswerList")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AnswerList",
 *     type="object",
 *     @OA\Property(
 *          property="attributes",
 *          type="object",
 *          @OA\AdditionalProperties(
 *              type="string"
 *          )
 *     ),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ListingAnswer")),
 *     @OA\Property(property="count", type="integer", example=32),
 *     @OA\Property(property="isEmpty", type="bool", example=false),
 * )
 */
