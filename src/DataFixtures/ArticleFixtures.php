<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    private static $articleTitles = [
        'The fellowship of the ring',
        'The two towers',
        'The return of the king',
    ];

    private static $articleAuthors = [
        'Bilbo Bagginns',
        'Gandalf the grey',
    ];

    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {
            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent('Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore.');

            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));

            $comment1 = new Comment();
            $comment1->setAuthorName('Trayan Ivanov');
            $comment1->setContent('Qwerty 123 lorem');
            $comment1->setArticle($article);
            $manager->persist($comment1);

            $comment2 = new Comment();
            $comment2->setAuthorName('Stefan Ivanov');
            $comment2->setContent('Blah blah blah');
            $comment2->setArticle($article);
            $manager->persist($comment2);
        });
        $manager->flush();
    }
}
