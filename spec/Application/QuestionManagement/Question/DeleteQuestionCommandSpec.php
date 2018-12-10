<?php

namespace spec\App\Application\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\DeleteQuestionCommand;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteQuestionCommandSpec extends ObjectBehavior
{

    private $questionId;

    public function let()
    {
        $this->questionId = new QuestionId();
        $this->beConstructedWith($this->questionId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteQuestionCommand::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }
}
