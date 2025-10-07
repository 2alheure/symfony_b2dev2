<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class ArticleController extends AbstractController {
    #[Route('/article/create', name: 'app_article')]
    public function index(EntityManagerInterface $em, Request $request): Response {
        $article = new Article;

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_article_liste');
        }

        return $this->render('article/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/articles', name: 'app_article_liste')]
    public function liste(ArticleRepository $ar): Response {

        $articles = $ar->findAll();

        return $this->render('article/liste.html.twig', [
            'articles' => $articles
        ]);
    }
}
