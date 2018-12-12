<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\AddAnswerCommand;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use App\Domain\Exception\QuestionNotFoundException;
use App\Domain\QuestionManagement\Question\QuestionId;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * AddAnswerController
 *
 * @package App\Controller\QuestionManagement\Answer\
 */
final class AddAnswerController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * Creates a AddAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $questionId
     * @param Request $request
     * @return Response
     *
     * @Route("/questions/{questionId}/answers", methods={"POST"})
     */
    public function add($questionId, Request $request): Response
    {
        $data = $this->parseRequest($request, ['body']);

        if (!$this->valid) {
            return $this->errorResponse;
        }

        try {
            $questionId = new QuestionId($questionId);
            $command = new AddAnswerCommand($this->currentUser(), $questionId, $data->body);
            $answer = $this->commandBus->handle($command);
        } catch (QuestionNotFoundException $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $error) {
            return $this->badRequest($error->getMessage());
        }

        return $this->response($answer);
    }
}


/**
 * @OA\Post(
 *     path="/questions/{questionId}/answers",
 *     tags={"Answers"},
 *     summary="Adds an answer",
 *     description="Adds an answer to the question with the ID provided in the URP path",
 *     operationId="addAnswer",
 *     @OA\Parameter(
 *         name="questionId",
 *         in="path",
 *         description="ID of question that will be answered",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     requestBody={"$ref": "#/components/requestBodies/AddAnswer"},
 *     @OA\Response(
 *         response=200,
 *         description="The newlly crated question",
 *         @OA\JsonContent(ref="#/components/schemas/Answer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     }
 * )
 */

/**
 * @OA\RequestBody(
 *     request="AddAnswer",
 *     description="Object containing the very minimal inforamtion nedded to create an answer",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/AddAnswer")
 * )
 *
 * @OA\Schema(
 *     schema="AddAnswer",
 *     title="AddAnswer",
 *     @OA\Property(property="body", type="string", example="A short and smart answer", description="Answer main body"),
 * )
 */