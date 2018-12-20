<?php

namespace spec\App\Domain\QuestionManagement\Answer\Specification;

use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\Specification\OnlyOneCorrectAnswerPerQuestion;
use App\Domain\QuestionManagement\Question;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OnlyOneCorrectAnswerPerQuestionSpec extends ObjectBehavior
{

    function let(
        Answer $answer1,
        Answer $answer2,
        Question $question
    ) {
        $question->answers()->willReturn([$answer2, $answer1]);
        $answer2->question()->willReturn($question);
        $answer2->isCorrectAnswer()->willReturn(false);
        $answer1->isCorrectAnswer()->willReturn(false);
        $answer2->equalsTo($answer2)->willReturn(true);
        $answer2->equalsTo($answer1)->willReturn(false);
        $answer1->equalsTo($answer1)->willReturn(true);
        $answer1->equalsTo($answer2)->willReturn(false);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OnlyOneCorrectAnswerPerQuestion::class);
    }

    function its_an_answer_specification()
    {
        $this->shouldBeAnInstanceOf(Answer\AnswerSpecification::class);
    }

    function it_verifies_single_answer(Answer $answer2)
    {
        $this->isSatisfiedBy($answer2)->shouldBe(true);
    }

    function it_dont_verify_multiple_answer(Answer $answer1, Answer $answer2)
    {
        $answer1->isCorrectAnswer()->willReturn(true);
        $this->isSatisfiedBy($answer2)->shouldBe(false);
    }
}
