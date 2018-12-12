<?php
/**
 * Created by PhpStorm.
 * User: fsilva
 * Date: 12-12-2018
 * Time: 17:57
 */

namespace App\Controller\QuestionManagement\Answer;


use App\Application\QuestionManagement\Answer\DeleteAnswerCommand;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\Exception\AnswerNotFoundException;
use App\Domain\QuestionManagement\Answer\AnswerId;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteAnswerController implements AuthenticatedControllerInterface
{
    use AuthenticatedControllerMethods, ApiControllerMethods;
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * DeleteAnswerController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @return Response
     *
     * @Route("/answers/{answerId}", methods={"DELETE"})
     */
    public function delete($answerId): Response
    {
        try {
            $answerId = new AnswerId($answerId);
            $this->commandBus->handle(new DeleteAnswerCommand($answerId));
        } catch (AnswerNotFoundException $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->badRequest($exception->getMessage());
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}

/**
 * @OA\Delete(
 *     path="/answers/{answerId}",
 *     tags={"Answers"},
 *     summary="Deletes an answer",
 *     description="Delete  the answer that matches the provided answer ID",
 *     operationId="deleteAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to delete",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="The answer was deleted",
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */