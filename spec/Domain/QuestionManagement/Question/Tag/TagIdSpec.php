<?php

namespace spec\App\Domain\QuestionManagement\Question\Tag;

use App\Domain\Common\RootAggregatorId;
use App\Domain\QuestionManagement\Question\Tag\TagId;
use PhpSpec\ObjectBehavior;

class TagIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TagId::class);
    }

    function its_a_root_aggregate_id()
    {
        $this->shouldHaveType(RootAggregatorId::class);
    }
}
