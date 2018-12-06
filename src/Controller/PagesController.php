<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * PagesController
 *
 * @package App\Controller
 */
final class PagesController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home()
    {
        return $this->redirect('/docs/index.html');
    }
}

/**
 * @OA\Info(
 *     title="Forum DAF",
 *     description="Este projecto visa criar uma API REST para desenvolvimento de um site ou aplicação de
          suporte, num formato de pergunta e respostas.<br />
          Tem como principal objectivo testar a capacidade do aluno criar uma aplicação web, com
          Symfony 4 e usando os padrões lecionados nas aulas da disciplina de “desenvolvimento de
          aplicações com frameworks.",
 *     version="v0.1.0",
 *     @OA\Contact(
 *          email="silvam.filipe@gmail.com"
 *     )
 * )
 */

/**
 * @OA\Tag(
 *     name="Users",
 *     description="User related endpoints"
 * )
 */