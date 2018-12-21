<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement\Answer\Specification;

use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\AnswerSpecification;
use App\Domain\UserManagement\UserIdentifier;

/**
 * UserOwnsAnswer
 *
 * @package App\Domain\QuestionManagement\Answer\Specification
 */
class UserOwnsAnswer implements AnswerSpecification
{
    /**
     * @var UserIdentifier
     */
    private $identifier;

    /**
     * Creates a UserOwnsAnswer
     *
     * @param UserIdentifier $identifier
     */
    public function __construct(UserIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Verify if passed answer satisfies current specification
     *
     * @param Answer $answer
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool
    {
        return $this->identifier->currentUser()->equalsTo($answer->user());
    }
}
