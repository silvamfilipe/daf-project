<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\UpdateAnswerCommand;
use App\Application\QuestionManagement\Answer\UpdateAnswerHandler;
use App\Domain\AnswersRepository;
use App\Domain\QuestionManagement\Answer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;

    function let(
        AnswersRepository $answersRepository,
        Answer $answer
    ) {

        $this->answerId = new Answer\AnswerId();
        $answersRepository->withAnswerId($this->answerId)->willReturn($answer);
        $answersRepository->update($answer)->willReturnArgument(0);

        $answer->updateBody(Argument::type('string'))->willReturn($answer);
        $this->beConstructedWith($answersRepository);
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
}
