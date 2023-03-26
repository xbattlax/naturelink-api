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

            $commentsData = [];
            foreach ($article->getComments() as $comment) {
                $commentsData[] = [
                    'id' => $comment->getId(),
                    'content' => $comment->getContent(),
                    'author' => $comment->getAuthor(),
                ];
            }

            $data[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'DateDePublication' => $article->getPublicationDate(),
                'content' => $article->getContent(),
                'img' => $article->getImg(),
                'tags' => $tagsData,
                'comments' => $commentsData,
            ];
        }

        return new JsonResponse($data);
    }


    #[Route('/public/articles/{id}/comment', name: 'get_article_comments', methods: ['GET'])]
    public function getArticleComments(int $id, ArticleRepository $articleRepository): JsonResponse
    {
        $article = $articleRepository->find($id);

        if (!$article) {
            return new JsonResponse('Article not found', JsonResponse::HTTP_NOT_FOUND);
        }

        $commentsData = [];
        foreach ($article->getComments() as $comment) {
            $commentsData[] = [
                'id' => $comment->getId(),
                'content' => $comment->getContent(),
                'author' => $comment->getAuthor(),
            ];
        }

        return new JsonResponse($commentsData);
    }
}
