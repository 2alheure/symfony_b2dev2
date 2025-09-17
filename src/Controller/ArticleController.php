<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ArticleController extends AbstractController {
    #[Route('/article/create', name: 'app_article')]
    public function index(EntityManagerInterface $em): Response {

        for ($i = 0 ; $i < 10000 ; $i++) {
            $article = new Article();
            $article->setTitre('Mon article n°' . $i);
            $article->setImg('https://placehold.co/600x400/png');
            $article->setDate(new \DateTime());
            $article->setContenu('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed');

            $em->persist($article);
        }

        $em->flush();

        return new Response('Article créé avec succès !');
    }

    #[Route('/articles', name: 'app_article_liste')]
    public function liste(ArticleRepository $ar): Response {

        $articles = $ar->findAll();

        return $this->render('article/liste.html.twig', [
            'articles' => $articles
        ]);
    }
}
