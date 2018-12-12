<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\AddAnswerCommand;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddAnswerCommandSpec extends ObjectBehavior
{

    private $body;
    private $questionId;

    /**
     * @param User|\PhpSpec\Wrapper\Collaborator $user
     * @throws \Exception
     */
    function let(User $user)
    {
        $this->body = 'body';
        $this->questionId = new QuestionId();
        $this->beConstructedWith($user, $this->questionId, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddAnswerCommand::class);
    }

    function it_has_a_user(User $user)
    {
        $this->user()->shouldBe($user);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }
}
