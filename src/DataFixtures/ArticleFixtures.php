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

        $articlesData = [
            [
                'title' => 'Les différentes techniques de chasse à l\'arc',
                'publicationDate' => new \DateTime('2022-01-15'),
                'content' => 'La chasse à l\'arc est une pratique ancestrale qui consiste à chasser des animaux sauvages avec un arc et des flèches. Il existe plusieurs techniques de chasse à l\'arc, chacune ayant ses avantages et ses inconvénients. Dans cet article, nous allons vous présenter les principales techniques de chasse à l\'arc, ainsi que les équipements nécessaires pour les pratiquer.',
                'img' => 'https://via.placeholder.com/150x150.png?text=Chasse+à+l\'arc',
                'tags' => ['chasse', 'arc', 'techniques'],
            ],
            [
                'title' => 'Les meilleurs spots de chasse en France',
                'publicationDate' => new \DateTime('2022-02-03'),
                'content' => 'La France est un pays riche en espaces naturels propices à la chasse. Que vous soyez passionné de chasse à l\'arc, de chasse à courre, de chasse en battue ou de chasse à l\'approche, vous trouverez forcément votre bonheur en France. Dans cet article, nous vous présentons les meilleurs spots de chasse de l\'hexagone, ainsi que les espèces que vous pourrez y chasser.',
                'img' => 'https://via.placeholder.com/150x150.png?text=Spots+de+chasse',
                'tags' => ['chasse', 'spots', 'France'],
            ],
            [
                'title' => 'Les règles d\'or pour réussir sa chasse à l\'approche',
                'publicationDate' => new \DateTime('2022-03-10'),
                'content' => 'La chasse à l\'approche est une technique de chasse qui consiste à se rapprocher des animaux sauvages en se dissimulant dans le milieu naturel. Cette technique demande de la patience, de la discrétion et une grande connaissance des habitudes des animaux chassés. Dans cet article, nous vous livrons les règles d\'or pour réussir votre chasse à l\'approche.',
                'img' => 'https://via.placeholder.com/150x150.png?text=Chasse+à+l\'approche',
                'tags' => ['chasse', 'approche', 'techniques'],
            ],
            [
                'title' => 'La régulation des populations de sangliers en France',
                'publicationDate' => new \DateTime('2022-02-10'),
                'content' => 'Les sangliers sont devenus une véritable nuisance en France, provoquant des dégâts considérables dans les cultures et les forêts. Pour réguler leur population, différentes techniques de chasse sont mises en place. Dans cet article, nous allons vous présenter les enjeux de la régulation des sangliers en France, ainsi que les moyens mis en oeuvre pour y parvenir.',
                'img' => 'https://via.placeholder.com/150x150.png?text=Population+sangliers',
                'tags' => ['chasse', 'sangliers', 'régulation'],
                ],
                
                [
                'title' => 'La migration des oies sauvages en Europe',
                'publicationDate' => new \DateTime('2022-03-08'),
                'content' => 'Chaque année, des millions d\'oies sauvages quittent leurs zones de reproduction en Scandinavie et en Russie pour se rendre en Europe de l\'Ouest. Cette migration est un spectacle fascinant qui attire de nombreux passionnés de nature et d\'ornithologie. Dans cet article, nous allons vous faire découvrir les principales espèces d\'oies migratrices en Europe, ainsi que les lieux où les observer.',
                'img' => 'https://via.placeholder.com/150x150.png?text=Migration+oies+sauvages',
                'tags' => ['nature', 'migration', 'oiseaux'],
                ],
                
                [
                'title' => 'Le retour du loup dans les Alpes françaises',
                'publicationDate' => new \DateTime('2022-04-20'),
                'content' => 'Après des décennies d\'absence, le loup est de retour dans les Alpes françaises depuis les années 1990. Ce retour a suscité des débats passionnés entre les défenseurs de l\'environnement et les éleveurs qui voient en cet animal une menace pour leurs troupeaux. Dans cet article, nous allons vous présenter les enjeux de la réintroduction du loup dans les Alpes françaises, ainsi que les mesures mises en place pour protéger les troupeaux.',
                'img' => 'https://via.placeholder.com/150x150.png?text=Retour+du+loup',
                'tags' => ['nature', 'loup', 'Alpes'],
                ],
        ];
        foreach ($articlesData as $articleData) {
            $article = new Article();
            $article->setTitle($articleData['title']);
            $article->setPublicationDate($articleData['publicationDate']);
            $article->setContent($articleData['content']);
            $article->setImg($articleData['img']);
    
            foreach ($articleData['tags'] as $tagName) {
                $tag = new Tags();
                $tag->setName($tagName);
                $manager->persist($tag);
                $article->addTag($tag);
            }
    
            $manager->persist($article);
        }
    
        $manager->flush();

    }
}
