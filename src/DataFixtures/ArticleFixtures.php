<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitle('Article ' . $i);
            $article->setPublicationDate(new \DateTime());
            $article->setContent('Article content ' . $i);
            $article->setImg('https://via.placeholder.com/150x150.png?text=Article+' . $i);

            for ($j = 1; $j <= 3; $j++) {
                $tag = new Tags();
                $tag->setName("Tag {$i}_{$j}");
                $manager->persist($tag);
                $article->addTag($tag);
            }

            $manager->persist($article);
        }

        $manager->flush();
    }
}
