<?php

namespace spec\App\Domain\QuestionManagement\Question;

use App\Domain\Common\RootAggregatorId;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionId::class);
    }

    function its_a_root_aggregate_id()
    {
        $this->shouldBeAnInstanceOf(RootAggregatorId::class);
    }
}
