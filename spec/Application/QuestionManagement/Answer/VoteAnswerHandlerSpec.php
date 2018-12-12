<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\VoteAnswerCommand;
use App\Application\QuestionManagement\Answer\VoteAnswerHandler;
use App\Domain\AnswersRepository;
use App\Domain\QuestionManagement\Answer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoteAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;

    function let(
        AnswersRepository $answersRepository,
        Answer $answer
    ) {
        $this->answerId = new Answer\AnswerId();
        $answersRepository->withAnswerId($this->answerId)->willReturn($answer);
        $answersRepository->update($answer)->willReturnArgument(0);
        $this->beConstructedWith($answersRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VoteAnswerHandler::class);
    }

    function it_handles_vote_answer_command(
        AnswersRepository $answersRepository,
        Answer $answer
    ) {
        $vote = Answer\Vote::positive();
        $command = new VoteAnswerCommand($this->answerId, $vote);
        $answer->addVote($vote)->shouldBeCalled()->willReturn($answer);

        $this->handle($command)->shouldBe($answer);
        $answersRepository->update($answer)->shouldBeCalled();
    }
}
