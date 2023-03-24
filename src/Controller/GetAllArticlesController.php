<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetAllArticlesController
{
    #[Route('/public/articles', name: 'get_all_articles', methods: ['GET'])]
    public function getAllArticles(ArticleRepository $articleRepository): JsonResponse
    {
        $articles = $articleRepository->findAll();

        $data = [];
        foreach ($articles as $article) {

            $tagsData = [];
            foreach ($article->getTags() as $tag) {
                $tagsData[] = $tag->getName(); // Assuming 'getName()' returns the tag's name as a string
            }

            $data[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'DateDePublication' => $article->getPublicationDate(),
                'content' => $article->getContent(),
                'img' => $article->getImg(),
                'tags' => $tagsData,
            ];
        }

        return new JsonResponse($data);
    }
}
