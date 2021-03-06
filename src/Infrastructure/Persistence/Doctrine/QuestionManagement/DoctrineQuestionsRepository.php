<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement;

use App\Domain\Exception\QuestionNotFoundException;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\QuestionManagement\Question\Tag;
use App\Domain\QuestionManagement\Question\Tag\TagId;
use App\Domain\QuestionManagement\QuestionsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DoctrineQuestionsRepository
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement
 */
final class DoctrineQuestionsRepository implements QuestionsRepository
{
    /**
     * @var EntityManagerInterface|EntityManager
     */
    private $entityManager;

    /**
     * DoctrineQuestionsRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Adds a question to de repository
     *
     * @param Question $question
     *
     * @return Question
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Question $question): Question
    {
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        return $question;
    }

    /**
     * Persists question changes
     *
     * @param Question $question
     *
     * @return Question
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Question $question): Question
    {
        $this->entityManager->flush($question);
        return $question;
    }

    /**
     * Remove question from repository
     *
     * @param Question $question
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(Question $question): void
    {
        $this->entityManager->remove($question);
        $this->entityManager->flush();
    }

    /**
     * @param QuestionId $questionId
     * @return Question
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws QuestionNotFoundException if no question was not found with provided ID
     */
    public function withQuestionId(QuestionId $questionId): Question
    {
        $question = $this->entityManager->find(Question::class, $questionId);

        if (!$question instanceof Question) {
            throw new QuestionNotFoundException(
                "Question not found!"
            );
        }

        return $question;
    }

    /**
     * Retrieve the tag with provided description
     *
     * @param string $tag
     *
     * @return Tag|null
     */
    public function tag(string $tag): ?Tag
    {
        $repository = $this->entityManager->getRepository(Tag::class);
        $existing = $repository->findOneBy(['description' => $tag]);

        return $existing instanceof Tag ? $existing : null;
    }

    /**
     * Retrieves the tag with provided tag ID
     *
     * @param TagId $tagId
     *
     * @return Tag|null
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function tagWithId(TagId $tagId): ?Tag
    {
        $tag = $this->entityManager->find(Tag::class, $tagId);

        return $tag instanceof Tag ? $tag : null;
    }
}