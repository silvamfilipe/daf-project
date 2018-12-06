<?php

namespace spec\App\Domain\QuestionManagement\Answer;

use App\Domain\QuestionManagement\Answer\Vote;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoteSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedThrough('positive', []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Vote::class);
    }

    function it_can_validate_if_positive()
    {
        $this->isPositive()->shouldBe(true);
    }

    function it_can_validate_if_negative()
    {
        $this->isNegative()->shouldBe(false);
    }

    function it_created_through_factory_methods()
    {
        $this->beConstructedThrough('negative');
        $this->isNegative()->shouldBe(true);
        $this->isPositive()->shouldBe(false);
    }
}
