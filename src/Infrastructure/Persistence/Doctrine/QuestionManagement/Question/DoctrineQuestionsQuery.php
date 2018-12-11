<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question;

use App\Application\Pagination;
use App\Application\QueryResult;
use App\Application\QuestionManagement\Model\Question;
use App\Application\QuestionManagement\Question\QuestionsQuery;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

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
     * @param Connection|\Doctrine\DBAL\Connection $connection
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
        $builder = $this->connection->createQueryBuilder();

        // Set the table and where clause
        $builder
            ->from('questions_list', 'q');

        $this->checkUserFilter($attributes, $builder);
        $this->checkTagFilter($attributes, $builder);
        $this->checkPatternFilter($attributes, $builder);

        // Retrieve total rows
        $pagination = $this->pagination($builder, $attributes);

        // Set fields, limit and order by
        $stm = $builder
            ->select('*')
            ->orderBy('datePublished', 'DESC')
            ->setFirstResult($pagination->firstResult())
            ->setMaxResults($pagination->maxResults())
            ->execute();

        $data = [];
        while ($row = $stm->fetch()) {
            $data[] = new Question($row);
        }

        $result = new QueryResult($data);
        foreach ($attributes as $name => $value) {
            $result->addAttribute($name, $value);
        }

        return $result->withPagination($pagination);
    }

    /**
     * Create pagination object
     *
     * @param QueryBuilder $builder
     * @param array        $attributes
     *
     * @return Pagination
     */
    private function pagination(QueryBuilder $builder, array $attributes): Pagination
    {
        $total = $this->count($builder);
        $page = (array_key_exists('page', $attributes))
            ? filter_var($attributes['page'], FILTER_SANITIZE_NUMBER_INT)
            : 1;
        $rowsPerPage = (array_key_exists('rows', $attributes))
            ? filter_var($attributes['rows'], FILTER_SANITIZE_NUMBER_INT)
            : 12;
        $pagination = new Pagination($total, $rowsPerPage);
        return $pagination->forPage($page);
    }

    /**
     * Count total rows for filter
     *
     * @param QueryBuilder $builder
     *
     * @return int
     */
    private function count(QueryBuilder $builder)
    {
        $builder = clone $builder;
        $stm = $builder->select('count(*) as rows')->execute();
        $first = $stm->fetch();
        return (int) $first['rows'];

    }

    /**
     * Adds user ID  filter
     *
     * @param array        $attributes
     * @param QueryBuilder $builder
     */
    private function checkUserFilter(array $attributes, QueryBuilder &$builder)
    {
        if (!array_key_exists('userId', $attributes)) {
            return;
        }

        $builder->where('q.userId = ?')->setParameter(0, $attributes['userId']);
    }

    /**
     * Adds tag filter
     *
     * @param array        $attributes
     * @param QueryBuilder $builder
     */
    private function checkTagFilter(array $attributes, QueryBuilder &$builder)
    {
        if (!array_key_exists('tag', $attributes)) {
            return;
        }

        $builder->where('q.tags LIKE ?')->setParameter(0, "%{$attributes['tag']}%");
    }

    /**
     * Adds search pattern filter
     *
     * @param array        $attributes
     * @param QueryBuilder $builder
     */
    private function checkPatternFilter(array $attributes, QueryBuilder &$builder)
    {
        if (!array_key_exists('pattern', $attributes)) {
            return;
        }

        $builder
            ->where('q.tags LIKE :pattern')
            ->orWhere('q.title LIKE :pattern')
            ->orWhere('q.email LIKE :pattern')
            ->orWhere('q.name LIKE :pattern')
            ->orWhere('q.body LIKE :pattern')

            ->setParameter('pattern', "%{$attributes['pattern']}%")
        ;
    }
}