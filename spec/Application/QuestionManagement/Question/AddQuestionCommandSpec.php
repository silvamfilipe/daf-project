<?php

namespace spec\App\Application\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\AddQuestionCommand;
use App\Domain\QuestionManagement\Question\Tag;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddQuestionCommandSpec extends ObjectBehavior
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
        $this->tags = [new Tag('php')];
        $this->beConstructedWith($user, $this->title, $this->body, $this->tags);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionCommand::class);
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
        $this->tags()->shouldBe($this->tags);
    }
}
