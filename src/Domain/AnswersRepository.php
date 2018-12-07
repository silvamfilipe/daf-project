<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain;

use App\Domain\Exception\AnswerNotFoundException;
use App\Domain\QuestionManagement\Answer;

/**
 * AnswersRepository
 *
 * @package App\Domain
 */
interface AnswersRepository
{

    /**
     * Add an answer to the repository
     *
     * @param Answer $answer
     *
     * @return Answer
     */
    public function add(Answer $answer): Answer;

    /**
     * Persists answer changes
     *
     * @param Answer $answer
     *
     * @return Answer
     */
    public function update(Answer $answer): Answer;

    /**
     * Remove answer from repository
     *
     * @param Answer $answer
     */
    public function remove(Answer $answer): void;

    /**
     * @param Answer\AnswerId $answerId
     * @return Answer
     *
     * @throws AnswerNotFoundException if no answer exists under provided ID
     */
    public function withAnswerId(Answer\AnswerId $answerId): Answer;
}
