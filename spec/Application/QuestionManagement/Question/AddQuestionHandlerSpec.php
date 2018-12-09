<?php

namespace spec\App\Application\QuestionManagement\Question;

use App\Application\QuestionManagement\Question\AddQuestionCommand;
use App\Application\QuestionManagement\Question\AddQuestionHandler;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddQuestionHandlerSpec extends ObjectBehavior
{

    private $tag;

    private $htmlTag;

    function let(QuestionsRepository $questions)
    {
        $this->htmlTag = new Question\Tag('html');
        $questions->add(Argument::type(Question::class))->willReturnArgument(0);
        $this->tag = new Question\Tag('css');
        $questions->tag('css')->willReturn($this->tag);
        $questions->tag(Argument::type('string'))->willReturn(null);
        $questions->tagWithId($this->htmlTag->tagId())->willReturn($this->htmlTag);
        $questions->tagWithId(Argument::any())->willReturn(null);
        $this->beConstructedWith($questions);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionHandler::class);
    }

    function it_handles_add_question_command(User $user, QuestionsRepository $questions)
    {
        $command = new AddQuestionCommand($user->getWrappedObject(), 'title', 'body');
        $question = $this->handle($command);
        $question->shouldBeAnInstanceOf(Question::class);
        $questions->add($question)->shouldHaveBeenCalled();
    }

    function it_can_convert_a_list_of_string_tags_to_tag_objects(User $user)
    {
        $command = new AddQuestionCommand($user->getWrappedObject(), 'title', 'body', ['php', 'css', ['tagId' => (string) $this->htmlTag->tagId(), 'name' => 'html']]);
        $question = $this->handle($command);
        $question->tags()[0]->shouldBeAnInstanceOf(Question\Tag::class);
        $question->tags()[1]->shouldBe($this->tag);
        $question->tags()[2]->shouldBe($this->htmlTag);
    }
}
