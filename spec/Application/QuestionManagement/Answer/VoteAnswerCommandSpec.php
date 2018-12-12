<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\VoteAnswerCommand;
use App\Domain\QuestionManagement\Answer\AnswerId;
use App\Domain\QuestionManagement\Answer\Vote;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoteAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;
    private $vote;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->vote = Vote::negative();
        $this->beConstructedWith($this->answerId, $this->vote);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VoteAnswerCommand::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_vote()
    {
        $this->vote()->shouldBe($this->vote);
    }
}
