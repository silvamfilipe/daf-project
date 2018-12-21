<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Answer;

use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\AnswersRepository;
use App\Domain\Exception\AnswerNotFoundException;
use App\Domain\QuestionManagement\Answer\AnswerId;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ReadAnswerController
 *
 * @package App\Controller\QuestionManagement\Answer
 */
final class ReadAnswerController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var AnswersRepository
     */
    private $answersRepository;

    /**
     * Creates a ReadAnswerController
     *
     * @param AnswersRepository $answersRepository
     */
    public function __construct(AnswersRepository $answersRepository)
    {
        $this->answersRepository = $answersRepository;
    }

    /**
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}", methods={"GET"})
     */
    public function read($answerId): Response
    {
        try {
            $answerId = new AnswerId($answerId);
            $answer = $this->answersRepository->withAnswerId($answerId);
        } catch (AnswerNotFoundException $exception) {
            return $this->badRequest($exception->getMessage());
        } catch (\Exception $caught) {
            return $this->badRequest($caught->getMessage());
        }

        return $this->response($answer);
    }
}


/**
 * @OA\Get(
 *     path="/answers/{answerId}",
 *     tags={"Answers"},
 *     summary="Retrieve the answer with provided ID",
 *     description="Returns an answer",
 *     operationId="getAnswerById",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to return",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The requested answer",
 *         @OA\JsonContent(ref="#/components/schemas/Answer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */
