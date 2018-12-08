<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement;

use App\Domain\AnswersRepository;
use App\Domain\Exception\AnswerNotFoundException;
use App\Domain\QuestionManagement\Answer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DoctrineAnswersRepository
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement
 */
final class DoctrineAnswersRepository implements AnswersRepository
{
    /**
     * @var EntityManagerInterface|EntityManager
     */
    private $entityManager;

    /**
     * Creates a DoctrineAnswersRepository
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Add an answer to the repository
     *
     * @param Answer $answer
     *
     * @return Answer
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Answer $answer): Answer
    {
        $this->entityManager->persist($answer);
        $this->entityManager->flush();
        return $answer;
    }

    /**
     * Persists answer changes
     *
     * @param Answer $answer
     *
     * @return Answer
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Answer $answer): Answer
    {
        $this->entityManager->flush($answer);
        return $answer;
    }

    /**
     * Remove answer from repository
     *
     * @param Answer $answer
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(Answer $answer): void
    {
        $this->entityManager->remove($answer);
    }

    /**
     * @param Answer\AnswerId $answerId
     * @return Answer
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws AnswerNotFoundException if no answer exists under provided ID
     */
    public function withAnswerId(Answer\AnswerId $answerId): Answer
    {
        $answer = $this->entityManager->find(Answer::class, $answerId);

        if (!$answer instanceof Answer) {
            throw new AnswerNotFoundException(
                "Answer not found!"
            );
        }

        return $answer;
    }
}
