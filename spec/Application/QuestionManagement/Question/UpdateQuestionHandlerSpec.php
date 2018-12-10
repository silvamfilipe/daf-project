<?php

namespace spec\App\Application\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\UpdateQuestionCommand;
use App\Application\QuestionManagement\Question\UpdateQuestionHandler;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateQuestionHandlerSpec extends ObjectBehavior
{

    private $questionId;
    private $title;
    private $body;

    /**
     * @param QuestionsRepository|\PhpSpec\Wrapper\Collaborator $questionsRepository
     * @param Question|\PhpSpec\Wrapper\Collaborator $question
     * @throws \Exception
     */
    function let(QuestionsRepository $questionsRepository, Question $question)
    {
        $this->questionId = new Question\QuestionId();
        $questionsRepository->withQuestionId($this->questionId)->willReturn($question);
        $questionsRepository->update($question)->willReturnArgument(0);
        $this->title = 'title';
        $this->body = 'body';
        $question->update($this->title, $this->body)->willReturn($question);
        $this->beConstructedWith($questionsRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateQuestionHandler::class);
    }

    function it_handle_update_question_command(QuestionsRepository $questionsRepository, Question $question)
    {
        $command = new UpdateQuestionCommand($this->questionId, $this->title, $this->body);
        $this->handle($command)->shouldBe($question);
        $question->update($this->title, $this->body)->shouldHaveBeenCalled();
        $questionsRepository->update($question)->shouldHaveBeenCalled();
    }
}
