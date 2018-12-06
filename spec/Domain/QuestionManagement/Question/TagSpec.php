<?php

namespace spec\App\Domain\QuestionManagement\Question;

use App\Domain\QuestionManagement\Question\Tag;
use App\Domain\Stringable;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagSpec extends ObjectBehavior
{

    private $description;

    function let()
    {
        $this->description = 'PHP7';
        $this->beConstructedWith($this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tag::class);
    }

    function it_has_a_tag_id()
    {
        $this->tagId()->shouldBeAnInstanceOf(Tag\TagId::class);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_can_be_converted_to_string()
    {
        $this->shouldBeAnInstanceOf(Stringable::class);
        $this->__toString()->shouldBe($this->description);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'tagId' => $this->tagId(),
            'description' => $this->description
        ]);
    }
}
