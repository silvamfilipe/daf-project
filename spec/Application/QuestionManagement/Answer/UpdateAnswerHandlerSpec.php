<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\UpdateAnswerCommand;
use App\Application\QuestionManagement\Answer\UpdateAnswerHandler;
use App\Domain\AnswersRepository;
use App\Domain\Exception\SpecificationFailureException;
use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\Specification\UserOwnsAnswer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;

    /**
     * @param AnswersRepository $answersRepository
     * @param Answer $answer
     * @throws \Exception
     */
    function let(
        AnswersRepository $answersRepository,
        Answer $answer,
        UserOwnsAnswer $userOwnsAnswer
    ) {

        $this->answerId = new Answer\AnswerId();
        $answersRepository->withAnswerId($this->answerId)->willReturn($answer);
        $answersRepository->update($answer)->willReturnArgument(0);

        $answer->updateBody(Argument::type('string'))->willReturn($answer);
        $userOwnsAnswer->isSatisfiedBy($answer)->willReturn(true);
        $this->beConstructedWith($answersRepository, $userOwnsAnswer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateAnswerHandler::class);
    }

    function it_handles_update_answer_command(
        AnswersRepository $answersRepository,
        Answer $answer
    ) {
        $command = new UpdateAnswerCommand($this->answerId, 'body');
        $this->handle($command)->shouldBe($answer);
        $answersRepository->update($answer)->shouldHaveBeenCalled();
    }

    function it_throws_exception_if_user_does_not_owns_the_answer(
        Answer $answer,
        UserOwnsAnswer $userOwnsAnswer
    )
    {
        $userOwnsAnswer->isSatisfiedBy($answer)->willReturn(false);
        $command = new UpdateAnswerCommand($this->answerId, 'body');

        $this->shouldThrow(SpecificationFailureException::class)
            ->during('handle', [$command]);
    }
}
