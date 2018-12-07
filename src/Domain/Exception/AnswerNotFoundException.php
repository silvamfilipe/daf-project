<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Exception;

use App\Exception;
use RuntimeException;

/**
 * AnswerNotFoundException
 *
 * @package App\Domain\Exception
 */
class AnswerNotFoundException extends RuntimeException implements Exception
{

}
