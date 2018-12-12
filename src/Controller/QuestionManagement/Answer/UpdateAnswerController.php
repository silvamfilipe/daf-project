<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\UpdateAnswerCommand;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\AnswersRepository;
use App\Domain\Exception\AnswerNotFoundException;
use App\Domain\QuestionManagement\Answer\AnswerId;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * UpdateAnswerController
 *
 * @package App\Controller\QuestionManagement\Answer
 */
final class UpdateAnswerController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var AnswersRepository|CommandBus
     */
    private $commandBus;

    /**
     * Creates a UpdateAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $answerId
     * @param Request $request
     * @return Response
     *
     * @Route("/answers/{answerId}", methods={"PATCH"})
     */
    public function update($answerId, Request $request): Response
    {
        $data = $this->parseRequest($request, ['body']);

        if (!$this->valid) {
            return $this->errorResponse;
        }

        try {
            $answerId = new AnswerId($answerId);
            $command = new UpdateAnswerCommand($answerId, $data->body);
            $answer = $this->commandBus->handle($command);
        } catch (AnswerNotFoundException $exception) {
            return $this->badRequest($exception, Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->badRequest($exception->getMessage());
        }

        return $this->response($answer);
    }
}


/**
 * @OA\Patch(
 *     path="/answers/{answerId}",
 *     tags={"Answers"},
 *     summary="Updates an answer",
 *     description="Updates the body of the answer that matches the provided answer ID",
 *     operationId="updateAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to update",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     requestBody={"$ref": "#/components/requestBodies/AddAnswer"},
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
