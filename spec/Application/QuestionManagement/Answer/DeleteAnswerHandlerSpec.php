<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\DeleteAnswerCommand;
use App\Application\QuestionManagement\Answer\DeleteAnswerHandler;
use App\Domain\AnswersRepository;
use App\Domain\QuestionManagement\Answer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;

    function let(
        AnswersRepository $answersRepository,
        Answer $answer
    ) {
        $this->answerId = new Answer\AnswerId();
        $answersRepository->withAnswerId($this->answerId)->willReturn($answer);

        $this->beConstructedWith($answersRepository);
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
}
