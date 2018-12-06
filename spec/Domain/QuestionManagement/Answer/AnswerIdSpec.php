<?php

namespace spec\App\Domain\QuestionManagement\Answer;

use App\Domain\Common\RootAggregatorId;
use App\Domain\QuestionManagement\Answer\AnswerId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AnswerIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerId::class);
    }

    function its_a_root_aggregate_identifier()
    {
        $this->shouldHaveType(RootAggregatorId::class);
    }
}
