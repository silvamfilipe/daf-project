<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Question;

use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\Exception\QuestionNotFoundException;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\QuestionManagement\QuestionsRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ReadQuestionController
 *
 * @package App\Controller\QuestionManagement\Question
 */
final class ReadQuestionController implements AuthenticatedControllerInterface
{
    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var QuestionsRepository
     */
    private $questionsRepository;

    /**
     * Creates a ReadQuestionController
     *
     * @param QuestionsRepository $questionsRepository
     */
    public function __construct(QuestionsRepository $questionsRepository)
    {
        $this->questionsRepository = $questionsRepository;
    }

    /**
     * @Route("/questions/{questionId}", methods={"GET"})
     *
     * @param $questionId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read($questionId)
    {
        try {
            $questionId = new QuestionId($questionId);
            $question = $this->questionsRepository->withQuestionId($questionId);
        } catch (QuestionNotFoundException $exception) {
            return $this->badRequest($exception->getMessage());
        } catch (\Exception $caught) {
            return $this->badRequest($caught->getMessage());
        }

        return $this->response($question);
    }
}


/**
 * @OA\Get(
 *     path="/questions/{questionId}",
 *     tags={"Questions"},
 *     summary="Retrieve the question with provided ID",
 *     description="Returns a question",
 *     operationId="getQuestionById",
 *     @OA\Parameter(
 *         name="questionId",
 *         in="path",
 *         description="ID of question to return",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The newlly crated question",
 *         @OA\JsonContent(ref="#/components/schemas/Question")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */