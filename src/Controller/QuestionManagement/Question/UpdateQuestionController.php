<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\UpdateQuestionCommand;
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
 * UpdateQuestionController
 *
 * @package App\Controller\QuestionManagement\Question
 */
final class UpdateQuestionController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * Creates a UpdateQuestionController
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
     * @Route("/questions/{questionId}", methods={"PATCH"})
     */
    public function update(Request $request, $questionId): Response
    {

        $data = $this->parseRequest($request, ['title', 'body']);

        if (!$this->valid) {
            return $this->errorResponse;
        }

        try {
            $questionId = new QuestionId($questionId);
            $command = new UpdateQuestionCommand($questionId, $data->title, $data->body);
            $question = $this->commandBus->handle($command);
        } catch (QuestionNotFoundException $exception) {
            $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->badRequest($exception->getMessage());
        }

        return $this->response($question);
    }
}

/**
 * @OA\Patch(
 *     path="/questions/{questionId}",
 *     tags={"Questions"},
 *     summary="Updates the question title and body",
 *     operationId="updateQuestion",
 *     @OA\Parameter(
 *         name="questionId",
 *         in="path",
 *         description="ID of question to update",
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
 *         response=200,
 *         description="The updated question",
 *         @OA\JsonContent(ref="#/components/schemas/Question")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     },
 *     requestBody={"$ref": "#/components/requestBodies/UpdateQuestion"}
 * )
 *
 * @OA\RequestBody(
 *     request="UpdateQuestion",
 *     description="Object containing the changed title and body of a question to be updated.",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/UpdateQuestion")
 * )
 *
 * @OA\Schema(
 *     schema="UpdateQuestion",
 *     title="Update Quesiton",
 *     @OA\Property(property="title", type="string", example="A simple question", description="Question title"),
 *     @OA\Property(property="body", type="string", example="How can we do something?", description="Question main boby"),
 * )
 */
