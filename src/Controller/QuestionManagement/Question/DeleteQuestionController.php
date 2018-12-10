<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\DeleteQuestionCommand;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\Exception\QuestionNotFoundException;
use App\Domain\QuestionManagement\Question\QuestionId;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * DeleteQuestionController
 *
 * @package App\Controller\QuestionManagement\Question
 */
final class DeleteQuestionController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * Creates a DeleteQuestionController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/questions/{questionId}", methods={"DELETE"})
     */
    public function delete($questionId)
    {
        try {
            $questionId = new QuestionId($questionId);
            $this->commandBus->handle(new DeleteQuestionCommand($questionId));
        } catch (QuestionNotFoundException $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->badRequest($exception->getMessage());
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}


/**
 * @OA\Delete(
 *     path="/questions/{questionId}",
 *     tags={"Questions"},
 *     summary="Delete a question",
 *     operationId="deleteQuestion",
 *     @OA\Parameter(
 *         name="questionId",
 *         in="path",
 *         description="ID of question to delete",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Missing property or errors regarding data sent."
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Question was delete"
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 *
 *
 */