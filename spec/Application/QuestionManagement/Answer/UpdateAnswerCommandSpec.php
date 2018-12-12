<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\UpdateAnswerCommand;
use App\Domain\QuestionManagement\Answer\AnswerId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateAnswerCommandSpec extends ObjectBehavior
{

    private $body;
    private $answerId;

    function let()
    {
        $this->body = 'body';
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateAnswerCommand::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }
}
