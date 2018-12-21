<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\DeleteAnswerCommand;
use App\Application\QuestionManagement\Answer\DeleteAnswerHandler;
use App\Domain\AnswersRepository;
use App\Domain\Exception\SpecificationFailureException;
use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\Specification\UserOwnsAnswer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;

    /**
     * @param AnswersRepository|\PhpSpec\Wrapper\Collaborator $answersRepository
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer
     * @param UserOwnsAnswer|\PhpSpec\Wrapper\Collaborator $
     * @throws \Exception
     */
    function let(
        AnswersRepository $answersRepository,
        Answer $answer,
        UserOwnsAnswer $userOwnsAnswer
    ) {
        $this->answerId = new Answer\AnswerId();
        $answersRepository->withAnswerId($this->answerId)->willReturn($answer);

        $userOwnsAnswer->isSatisfiedBy($answer)->willReturn(true);

        $this->beConstructedWith($answersRepository, $userOwnsAnswer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteAnswerHandler::class);
    }

    function it_handles_remove_answer_command(
        AnswersRepository $answersRepository,
        Answer $answer
    ) {
        $command = new DeleteAnswerCommand($this->answerId);
        $answersRepository->remove($answer)->shouldBeCalled();

        $this->handle($command)->shouldBe($answer);
    }

    function it_throws_exception_when_user_dont_owns_the_answer(
        Answer $answer,
        UserOwnsAnswer $userOwnsAnswer
    )
    {
        $command = new DeleteAnswerCommand($this->answerId);
        $userOwnsAnswer->isSatisfiedBy($answer)->willReturn(false);

        $this->shouldThrow(SpecificationFailureException::class)
            ->during('handle', [$command]);
    }
}
