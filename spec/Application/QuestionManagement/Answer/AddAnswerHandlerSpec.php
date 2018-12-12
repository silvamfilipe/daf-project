<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\AddAnswerCommand;
use App\Application\QuestionManagement\Answer\AddAnswerHandler;
use App\Application\QuestionManagement\Question\AddQuestionCommand;
use App\Domain\AnswersRepository;
use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\QuestionManagement\QuestionsRepository;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddAnswerHandlerSpec extends ObjectBehavior
{
    private $questionId;

    /**
     * @param AnswersRepository|\PhpSpec\Wrapper\Collaborator $answersRepository
     * @param QuestionsRepository|\PhpSpec\Wrapper\Collaborator $questionsRepository
     * @param Question|\PhpSpec\Wrapper\Collaborator $question
     * @throws \Exception
     */
    function let(
        AnswersRepository $answersRepository,
        QuestionsRepository $questionsRepository,
        Question $question
    ) {

        $this->questionId = new QuestionId();
        $questionsRepository->withQuestionId($this->questionId)->willReturn($question);

        $answersRepository->add(Argument::type(Answer::class))->willReturnArgument(0);
        $this->beConstructedWith($answersRepository, $questionsRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddAnswerHandler::class);
    }

    function it_handles_the_add_answer_command(
        AnswersRepository $answersRepository,
        User $user
    ) {
        $command = new AddAnswerCommand($user->getWrappedObject(), $this->questionId, 'body');
        $answer = $this->handle($command);
        $answer->shouldBeAnInstanceOf(Answer::class);
        $answersRepository->add($answer)->shouldHaveBeenCalled();
    }
}
