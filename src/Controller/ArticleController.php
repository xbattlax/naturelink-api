<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tags;
use App\Repository\ArticleRepository;
use App\Repository\TagsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/api/article")
 */
class ArticleController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ArticleRepository $articleRepository;
    private SerializerInterface $serializer;
    private TagsRepository $tagsRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        SerializerInterface $serializer,
        TagsRepository $tagsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->serializer = $serializer;
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * @Route("/post", name="post_article", methods={"POST"})
     */
    public function postArticle(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title'], $data['content'], $data['tags'])) {
            return $this->json([
                'status' => 'error',
                'message' => 'Les données requises ne sont pas présentes dans la requête.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $article = new Article();
        $article->setPublicationDate(new \DateTimeImmutable());
        $article->setTitle($data['title']);
        $article->setContent($data['content']);
        $tagsData = $data['tags'];

        $tags = explode(',', $tagsData);

        foreach ($tags as $tagName) {
            $tagName = trim($tagName);

            if (!empty($tagName)) {
                $tag = $this->tagsRepository->findOneBy(['name' => $tagName]);

                if (!$tag) {
                    $tag = new Tags();
                    $tag->setName($tagName);
                    $this->entityManager->persist($tag);
                }

                $article->addTag($tag);
            }
        }

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $this->json([
            'status' => 'success',
            'message' => 'Article créé avec succès',
            'data' => $article
        ], Response::HTTP_CREATED);
    }

}

