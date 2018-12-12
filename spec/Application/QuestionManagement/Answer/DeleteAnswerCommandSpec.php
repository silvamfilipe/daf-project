<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\DeleteAnswerCommand;
use App\Domain\QuestionManagement\Answer\AnswerId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteAnswerCommand::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }
}
