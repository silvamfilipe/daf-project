<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\AddQuestionCommand;
use App\Controller\ApiControllerMethods;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Controller\UserManagement\OAuth2\AuthenticatedControllerMethods;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * CreateQuestionController
 *
 * @package App\Controller\QuestionManagement\Question
 */
final class CreateQuestionController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods, ApiControllerMethods;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * Creates a CreateQuestionController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/questions", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = $this->parseRequest($request, ['title', 'body']);

        if (!$this->valid) {
            return $this->errorResponse;
        }

        $command = new AddQuestionCommand(
            $this->currentUser(),
            $data->title,
            $data->body,
            property_exists($data, 'tags') ? $data->tags : []
        );

        $question = $this->commandBus->handle($command);
        return $this->response($question);
    }
}

/**
 * @OA\Post(
 *     path="/questions",
 *     tags={"Questions"},
 *     summary="Adds a new question for authenticated user",
 *     operationId="addQuestion",
 *     @OA\Response(
 *         response=400,
 *         description="Missing property or errors regarding data sent."
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The newlly crated question",
 *         @OA\JsonContent(ref="#/components/schemas/Question")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"forum.usage"}}
 *     },
 *     requestBody={"$ref": "#/components/requestBodies/AddQuestion"}
 * )
 *
 * @OA\RequestBody(
 *     request="AddQuestion",
 *     description="Object containing the very minimal inforamtion nedded to create a question",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/AddQuestion")
 * )
 *
 * @OA\Schema(
 *     schema="AddQuestion",
 *     title="Add Quesiton",
 *     @OA\Property(property="title", type="string", example="A simple question", description="Question title"),
 *     @OA\Property(property="body", type="string", example="How can we do something?", description="Question main boby"),
 *     @OA\Property(
 *          property="tags",
 *          type="array",
 *          description="Question title",
 *          @OA\Items(type="string", example="PHP7")
 *     )
 * )
 */