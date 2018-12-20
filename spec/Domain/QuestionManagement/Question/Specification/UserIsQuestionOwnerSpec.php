<?php

namespace spec\App\Domain\QuestionManagement\Question\Specification;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\Specification\UserIsQuestionOwner;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserIsQuestionOwnerSpec extends ObjectBehavior
{
    function let(UserIdentifier $identifier, User $user, Question $question)
    {
        $identifier->currentUser()->willReturn($user);
        $question->user()->willReturn($user);
        $user->equalsTo($user)->willReturn(true);

        $this->beConstructedWith($identifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserIsQuestionOwner::class);
    }

    function its_a_question_specification()
    {
        $this->shouldBeAnInstanceOf(Question\QuestionSpecification::class);
    }

    function it_verifies_current_user_is_owner_of_the_question(Question $question)
    {
        $this->isSatisfiedBy($question)->shouldBe(true);
    }
}
