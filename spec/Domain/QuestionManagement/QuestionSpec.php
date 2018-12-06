<?php

namespace spec\App\Domain\QuestionManagement;

use App\Domain\QuestionManagement\Question;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionSpec extends ObjectBehavior
{
    private $title;
    private $body;
    private $tags;

    /**
     * @param User|\PhpSpec\Wrapper\Collaborator $user
     * @throws \Exception
     */
    function let(User $user)
    {
        $this->title = 'Title';
        $this->body = 'Body';
        $this->tags = [new Question\Tag('test'), new Question\Tag('phpspec')];

        $this->beConstructedWith($user, $this->title, $this->body, $this->tags);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Question::class);
    }

    function it_can_be_constructed_without_tags(User $user)
    {
        $this->beConstructedWith($user, $this->title, $this->body);
        $tags = $this->tags();
        $tags->shouldBeArray();
        $tags->shouldHaveCount(0);
    }

    function it_has_an_question_id()
    {
        $this->questionId()->shouldBeAnInstanceOf(Question\QuestionId::class);
    }

    function it_has_a_published_date()
    {
        $this->datePublished()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_user(User $user)
    {
        $this->user()->shouldBe($user);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_has_a_list_of_tags()
    {
        $tags = $this->tags();
        $tags->shouldBeArray();
        $tags->shouldBe($this->tags);
    }

    function it_can_update_its_title_and_body()
    {
        $title = 'title1';
        $body = 'body1';
        $this->update($title, $body)->shouldBe($this->getWrappedObject());
        $this->title()->shouldBe($title);
        $this->body()->shouldBe($body);
    }

    /**
     * @throws \Exception
     */
    function it_can_add_more_tags()
    {
        $tag = new Question\Tag('other');
        $tags = [$tag];

        $this->addTags($tags)->shouldBe($this->getWrappedObject());

        $tags = $this->tags();
        $tags->shouldBeArray();
        $tags->shouldHaveCount(3);
        $tags[2]->shouldBe($tag);
    }
}
