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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    #[Route('/articles/{id}/update', name: 'app_article_update')]
    public function update($id, ArticleRepository $ar, Request $request, EntityManagerInterface $em): Response {
        // J'utilise l'ID de l'URL pour récupérer l'article en BDD
        $article = $ar->find($id);
        if (!$article) {
            throw new NotFoundHttpException("L'article $id n'existe pas");
        }

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

    #[Route('/articles/{id}', name: 'app_article_detail')]
    public function detail(Article $article): Response {

        // Symfony va automatiquement récupérer l'article en BDD
        // grâce à l'ID dans l'URL et l'injection de dépendance
        // Si l'article n'existe pas, une 404 sera automatiquement générée

        return $this->render('article/details.html.twig', [
            'article' => $article
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
