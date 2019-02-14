<?php

namespace App\Controller;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, MarkdownInterface $markdown, AdapterInterface $cache)
    {
        $content = 'Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident beef ribs aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow turkey shank eu pork belly meatball non cupim.';

        $item = $cache->getItem('markdown_' . md5($content));
        if (!$item->isHit()) {
            $item->set($markdown->transform($content));
            $cache->save($item);
        }
        $content = $item->get();

        $comments = [
            'Comment 1',
            'Comment 2',
            'Comment 3',
        ];

        return $this->render('article/show.html.twig', [
            'slug' => $slug,
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'content' => $content,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        // TODO - db stuff

        $logger->info('Article is hearted.');

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}
