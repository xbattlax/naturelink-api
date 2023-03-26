<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddCommentController
{
    #[Route('/api/article/{id}/comment', name: 'add_comment', methods: ['POST'])]
    public function addComment(
        int $id,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em
    ): Response {
        $data = json_decode($request->getContent(), true);
        $articleRepository = $em->getRepository(Article::class);

        $article = $articleRepository->find($id);

        if (!$article) {
            return new Response('Article not found', Response::HTTP_NOT_FOUND);
        }

        $comment = new Comment();
        $comment->setContent($data['content']);
        $comment->setAuthor($data['author']);
        $comment->setArticle($article);

        $em->persist($comment);
        $em->flush();

        $serializedComment = $serializer->serialize($comment, 'json');

        return new Response($serializedComment, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json',
        ]);
    }
}
