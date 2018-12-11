<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\QuestionsQuery;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MyQuestionsList
 *
 * @package App\Controller\QuestionManagement\Question
 */
class MyQuestionsList implements AuthenticatedControllerInterface
{
    use AuthenticatedControllerMethods, ApiControllerMethods;
    /**
     * @var QuestionsQuery
     */
    private $questionsQuery;

    /**
     * Creates a MyQuestionsList
     *
     * @param QuestionsQuery $questionsQuery
     */
    public function __construct(QuestionsQuery $questionsQuery)
    {
        $this->questionsQuery = $questionsQuery;
    }

    /**
     * @Route("/my/questions", methods={"GET"})
     */
    public function myList(Request $request)
    {
        $attributes = $request->query->all();
        $attributes['userId'] = (string) $this->currentUser()->userId();
        return $this->response($this->questionsQuery->__invoke($attributes));
    }
}


/**
 * @OA\Get(
 *     path="/my/questions",
 *     tags={"Questions"},
 *     summary="Returns a list of questions",
 *     description="Returns a paginated list of my questions",
 *     operationId="getMyQuestions",
 *     @OA\Parameter(
 *         name="tag",
 *         in="query",
 *         description="Tag name to filter",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
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
 *         description="A list of user questions",
 *         @OA\JsonContent(ref="#/components/schemas/ListingQuestion")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */