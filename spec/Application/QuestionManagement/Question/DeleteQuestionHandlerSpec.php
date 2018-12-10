<?php

namespace spec\App\Application\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\DeleteQuestionCommand;
use App\Application\QuestionManagement\Question\DeleteQuestionHandler;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteQuestionHandlerSpec extends ObjectBehavior
{

    private $questionId;

    /**
     * @param QuestionsRepository|\PhpSpec\Wrapper\Collaborator $questionsRepository
     * @param Question|\PhpSpec\Wrapper\Collaborator $question
     * @throws \Exception
     */
    function let(QuestionsRepository $questionsRepository, Question $question)
    {
        $this->questionId = new Question\QuestionId();
        $questionsRepository->withQuestionId($this->questionId)->willReturn($question);
        $this->beConstructedWith($questionsRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteQuestionHandler::class);
    }

    function it_handle_delete_question_command(QuestionsRepository $questionsRepository, Question $question)
    {
        $command = new DeleteQuestionCommand($this->questionId);

        $questionsRepository->remove($question)->shouldBeCalled();

        $this->handle($command);
    }
}
