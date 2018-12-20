<?php

namespace spec\App\Domain\QuestionManagement;

use App\Domain\Comparable;
use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Question;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;

class AnswerSpec extends ObjectBehavior
{

    private $body;
    private $questionId;

    function let(User $user, Question $question)
    {
        $this->body = 'Body';
        $this->questionId = new Question\QuestionId();
        $question->questionId()->willReturn($this->questionId);
        $this->beConstructedWith($user, $question, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBeAnInstanceOf(Answer\AnswerId::class);
    }

    function it_has_a_publish_date()
    {
        $this->datePublished()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_user(User $user)
    {
        $this->user()->shouldBe($user);
    }

    function it_has_a_question(Question $question)
    {
        $this->question()->shouldBe($question);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_can_update_it_body()
    {
        $body = 'test';
        $this->updateBody($body)->shouldBe($this->getWrappedObject());
        $this->body()->shouldBe($body);
    }

    function it_can_be_set_as_a_correct_answer()
    {
        $this->isCorrectAnswer()->shouldBe(false);
        $this->setAsCorrect()->shouldBe($this->getWrappedObject());
        $this->isCorrectAnswer()->shouldBe(true);
    }

    function it_can_be_voted_positively()
    {
        $this->addVote(Answer\Vote::positive())->shouldBe($this->getWrappedObject());
        $this->positiveVotes()->shouldBe(1);
        $this->negativeVotes()->shouldBe(0);
    }

    function it_can_be_voted_negatively()
    {
        $this->addVote(Answer\Vote::negative())->shouldBe($this->getWrappedObject());
        $this->positiveVotes()->shouldBe(0);
        $this->negativeVotes()->shouldBe(1);
    }

    function it_can_be_converted_to_json(Question $question, User $user)
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'answerId' => $this->answerId(),
            'questionId' => $this->questionId,
            'body' => $this->body,
            'isCorrectAnswer' => $this->isCorrectAnswer(),
            'positiveVotes' => $this->positiveVotes(),
            'negativeVotes' => $this->negativeVotes(),
            'datePublished' => $this->datePublished(),
            'user' => $user
        ]);
    }

    function it_can_be_compared_to_other_answer(Answer $other)
    {
        $other->answerId()->willReturn($this->answerId()->getWrappedObject());
        $this->shouldBeAnInstanceOf(Comparable::class);
        $this->equalsTo($other)->shouldBe(true);
    }
}
