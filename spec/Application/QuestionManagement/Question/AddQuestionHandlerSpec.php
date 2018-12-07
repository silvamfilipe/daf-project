<?php

namespace spec\App\Application\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\AddQuestionCommand;
use App\Application\QuestionManagement\Question\AddQuestionHandler;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddQuestionHandlerSpec extends ObjectBehavior
{

    function let(QuestionsRepository $questions)
    {
        $questions->add(Argument::type(Question::class))->willReturnArgument(0);
        $this->beConstructedWith($questions);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionHandler::class);
    }

    function it_handles_add_question_command(User $user, QuestionsRepository $questions)
    {
        $command = new AddQuestionCommand($user->getWrappedObject(), 'title', 'body');
        $question = $this->handle($command);
        $question->shouldBeAnInstanceOf(Question::class);
        $questions->add($question)->shouldHaveBeenCalled();
    }
}
