<?php

namespace spec\App\Domain\QuestionManagement;

use App\Domain\QuestionManagement\Answer;
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

    /**
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer
     * @throws \Exception
     */
    function it_has_a_list_of_answers(Answer $answer)
    {
        $answerId = new Answer\AnswerId();
        $answer->answerId()->willReturn($answerId);

        $answers = $this->answers();
        $answers->shouldBeArray();
        $answers->shouldHaveCount(0);

        $this->addAnswer($answer)->shouldBe($this->getWrappedObject());

        $answers = $this->answers();
        $answers->shouldBeArray();
        $answers->shouldHaveCount(1);
        $answers[(string) $answerId]->shouldBe($answer);
    }

    /**
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer1
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer2
     * @throws \Exception
     */
    function it_can_remove_a_answer(Answer $answer1, Answer $answer2)
    {
        $answerId1 = new Answer\AnswerId();
        $answer1->answerId()->willReturn($answerId1);

        $answerId2 = new Answer\AnswerId();
        $answer2->answerId()->willReturn($answerId2);

        $this->addAnswer($answer1)->addAnswer($answer2);

        $answers = $this->answers();
        $answers->shouldHaveCount(2);
        $answers[(string) $answerId2]->shouldBe($answer2);

        $this->removeAnswer($answer1)->shouldBe($this->getWrappedObject());

        $answers = $this->answers();
        $answers->shouldHaveCount(1);
        $answers[(string) $answerId2]->shouldBe($answer2);
    }

    /**
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer1
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer2
     * @throws \Exception
     */
    function it_can_have_a_correct_answer(Answer $answer1, Answer $answer2)
    {
        $this->correctAnswer()->shouldBeNull();

        $answerId1 = new Answer\AnswerId();
        $answer1->answerId()->willReturn($answerId1);
        $answer1->isCorrectAnswer()->willReturn(false);

        $answerId2 = new Answer\AnswerId();
        $answer2->answerId()->willReturn($answerId2);
        $answer2->isCorrectAnswer()->willReturn(true);

        $this->addAnswer($answer1)->addAnswer($answer2);

        $this->correctAnswer()->shouldBe($answer2);
    }
}
