<?php

namespace spec\App\Application\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\UpdateQuestionCommand;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateQuestionCommandSpec extends ObjectBehavior
{
    private $questionId;
    private $title;
    private $body;

    /**
     * @throws \Exception
     */
    function let()
    {
        $this->questionId = new QuestionId();
        $this->title = 'title';
        $this->body = 'body';
        $this->beConstructedWith($this->questionId, $this->title, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateQuestionCommand::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }
}
