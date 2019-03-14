<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) {
            $article->setTitle('Lorem ipsum')
                ->setSlug('ipsum' . $count)
                ->setContent('Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore.');

            if (rand(1, 10) > 2) {
                $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
            }

            $article->setAuthor('Frodo Baggins')
                ->setHeartCount(rand(5, 100))
                ->setImageFilename('asteroid.jpeg');
        });
        $manager->flush();
    }
}
