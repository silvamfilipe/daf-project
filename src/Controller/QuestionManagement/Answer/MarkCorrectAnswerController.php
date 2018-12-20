<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\MarkCorrectAnswerCommand;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\Exception\AnswerNotFoundException;
use App\Domain\Exception\SpecificationFailureException;
use App\Domain\QuestionManagement\Answer\AnswerId;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MarkCorrectAnswerController
 *
 * @package App\Controller\QuestionManagement\Answer
 */
class MarkCorrectAnswerController implements AuthenticatedControllerInterface
{
    use AuthenticatedControllerMethods, ApiControllerMethods;
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * Creates a MarkCorrectAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @return Response
     *
     * @Route("/answers/{answerId}/mark-as-correct", methods={"PATCH", "POST"})
     */
    public function handle($answerId): Response
    {
        try {
            $answerId = new AnswerId($answerId);
            $command = new MarkCorrectAnswerCommand($answerId);
            $answer = $this->commandBus->handle($command);
        } catch (SpecificationFailureException $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_CONFLICT);
        } catch (AnswerNotFoundException $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->badRequest($exception->getMessage());
        }

        return $this->response($answer);
    }
}

/**
 * @OA\Patch(
 *     path="/answers/{answerId}/mark-as-correct",
 *     tags={"Answers"},
 *     summary="Mark an answer as correct",
 *     description="Marks the answer as the correct for its question",
 *     operationId="markCorrectAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to mark as correct",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The updated answer",
 *         @OA\JsonContent(ref="#/components/schemas/Answer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */
