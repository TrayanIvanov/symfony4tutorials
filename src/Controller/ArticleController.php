<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
use Nexy\Slack\Client as SlackClient;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $slackClient;

    public function __construct(SlackClient $slackClient)
    {
        $this->slackClient = $slackClient;
    }

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
    public function show($slug, MarkdownHelper $markdownHelper)
    {
        if ($slug === 'ipsum') {
            $message = $this->slackClient->createMessage()
                ->from('Bilbo Baggins')
                ->withIcon(':doge:')
                ->setText('There and back again');

            $this->slackClient->sendMessage($message);
        }

        $content = 'Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident beef ribs aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow turkey shank eu pork belly meatball non cupim.';

        $comments = [
            'Comment 1',
            'Comment 2',
            'Comment 3',
        ];

        $content = $markdownHelper->parse($content);

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
