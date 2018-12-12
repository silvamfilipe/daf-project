<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\VoteAnswerCommand;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\Exception\AnswerNotFoundException;
use App\Domain\QuestionManagement\Answer\AnswerId;
use App\Domain\QuestionManagement\Answer\Vote;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * VoteAnswerController
 *
 * @package App\Controller\QuestionManagement\Answer
 */
final class VoteAnswerController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * Creates a VoteAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}/vote-up", methods={"PUT"})
     */
    public function voteUp($answerId): Response
    {
        $vote = Vote::positive();

        return $this->vote($vote, $answerId);
    }

    /**
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}/vote-down", methods={"PUT"})
     */
    public function voteDown($answerId): Response
    {
        $vote = Vote::negative();

        return $this->vote($vote, $answerId);
    }

    private function vote(Vote $vote, $answerId)
    {
        try {
            $answerId = new AnswerId($answerId);
            $command = new VoteAnswerCommand($answerId, $vote);
            $answer = $this->commandBus->handle($command);
        } catch (AnswerNotFoundException $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->badRequest($exception->getMessage());
        }

        return $this->response($answer);
    }
}


/**
 * @OA\Put(
 *     path="/answers/{answerId}/vote-up",
 *     tags={"Answers"},
 *     summary="Vote up an answer",
 *     description="Adds a positive/up vote to the answer that matches the provided answer ID",
 *     operationId="voteUpAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to vote",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The updated question",
 *         @OA\JsonContent(ref="#/components/schemas/Answer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */

/**
 * @OA\Put(
 *     path="/answers/{answerId}/vote-down",
 *     tags={"Answers"},
 *     summary="Vote down an answer",
 *     description="Adds a negative/down vote to the answer that matches the provided answer ID",
 *     operationId="voteDownAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to vote",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The updated question",
 *         @OA\JsonContent(ref="#/components/schemas/Answer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */