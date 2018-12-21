<?php

namespace spec\App\Domain\QuestionManagement\Answer\Specification;

use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\AnswerSpecification;
use App\Domain\QuestionManagement\Answer\Specification\UserOwnsAnswer;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;
use PhpSpec\ObjectBehavior;

class UserOwnsAnswerSpec extends ObjectBehavior
{
    function let(UserIdentifier $identifier, User $user)
    {
        $identifier->currentUser()->willReturn($user);
        $this->beConstructedWith($identifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserOwnsAnswer::class);
    }

    function its_an_answer_identifier()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function it_check_if_current_user_owns_checked_answer(User $user, Answer $answer)
    {
        $answer->user()->willReturn($user);
        $user->equalsTo($user)->willReturn(true);

        $this->isSatisfiedBy($answer)->shouldBe(true);
    }
}
