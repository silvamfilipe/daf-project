<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question;

use App\Application\QueryResult;
use App\Application\QuestionManagement\Question\QuestionsQuery;
use Doctrine\DBAL\Driver\Connection;

/**
 * Doctrine Questions Query
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question
 */
class DoctrineQuestionsQuery implements QuestionsQuery
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * DoctrineQuestionsQuery constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Returns a query result for provided attribute list
     *
     * @param array $attributes
     *
     * @return QueryResult
     */
    public function __invoke(array $attributes = []): QueryResult
    {
        // TODO: Implement __invoke() method.
    }
}