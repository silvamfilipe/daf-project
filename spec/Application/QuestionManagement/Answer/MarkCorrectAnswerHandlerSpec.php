<?php

namespace spec\App\Application\QuestionManagement\Answer;

use App\Application\QuestionManagement\Answer\MarkCorrectAnswerCommand;
use App\Application\QuestionManagement\Answer\MarkCorrectAnswerHandler;
use App\Domain\AnswersRepository;
use App\Domain\Exception\SpecificationFailureException;
use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\Specification\OnlyOneCorrectAnswerPerQuestion;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\Specification\UserIsQuestionOwner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkCorrectAnswerHandlerSpec extends ObjectBehavior
{
    private $answerId;

    /**
     * @param AnswersRepository|\PhpSpec\Wrapper\Collaborator $answersRepository
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer
     * @param UserIsQuestionOwner $isQuestionOwner
     * @param Question $question
     * @param OnlyOneCorrectAnswerPerQuestion $oneCorrectAnswerPerQuestion
     * @throws \Exception
     */
    function let(
        AnswersRepository $answersRepository,
        Answer $answer,
        UserIsQuestionOwner $isQuestionOwner,
        Question $question,
        OnlyOneCorrectAnswerPerQuestion $oneCorrectAnswerPerQuestion
    ) {
        $this->answerId = new Answer\AnswerId();
        $answersRepository->withAnswerId($this->answerId)->willReturn($answer);
        $answer->setAsCorrect()->willReturn($answer);
        $answersRepository->update($answer)->willReturnArgument(0);
        $isQuestionOwner->isSatisfiedBy($question)->willReturn(true);
        $answer->question()->willReturn($question);
        $oneCorrectAnswerPerQuestion->isSatisfiedBy($answer)->willReturn(true);

        $this->beConstructedWith($answersRepository, $isQuestionOwner, $oneCorrectAnswerPerQuestion);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MarkCorrectAnswerHandler::class);
    }

    function it_handles_mark_answer_as_correct_command(
        AnswersRepository $answersRepository,
        Answer $answer
    ) {
        $command = new MarkCorrectAnswerCommand($this->answerId);
        $this->handle($command)->shouldBe($answer);
        $answer->setAsCorrect()->shouldHaveBeenCalled();
        $answersRepository->update($answer)->shouldHaveBeenCalled();
    }

    function it_throws_exception_if_question_dont_belongs_to_current_user(
        UserIsQuestionOwner $isQuestionOwner,
        Question $question
    ) {
        $command = new MarkCorrectAnswerCommand($this->answerId);
        $isQuestionOwner->isSatisfiedBy($question)->willReturn(false);
        $this->shouldThrow(SpecificationFailureException::class)
            ->during('handle', [$command]);
    }

    function it_throws_exception_if_question_is_already_answered(
        OnlyOneCorrectAnswerPerQuestion $oneCorrectAnswerPerQuestion,
        Answer $answer
    ) {
        $command = new MarkCorrectAnswerCommand($this->answerId);
        $oneCorrectAnswerPerQuestion->isSatisfiedBy($answer)->willReturn(false);
        $this->shouldThrow(SpecificationFailureException::class)
            ->during('handle', [$command]);
    }
}
