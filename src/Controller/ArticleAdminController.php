<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();
        $article->setTitle('Lorem ipsum')
            ->setSlug('ipsum' . rand(100, 999))
            ->setContent('Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore.');

        if (rand(1, 10) > 2) {
            $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }

        $article->setAuthor('Frodo Baggins')
            ->setHeartCount(rand(5, 100))
            ->setImageFilename('asteroid.jpeg');

        $em->persist($article);
        $em->flush();

        return new Response(sprintf(
            'job done.. | id: %d | slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}
