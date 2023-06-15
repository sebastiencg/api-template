<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Dicton;
use App\Repository\AuthorRepository;
use App\Repository\DictonRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorController extends AbstractController
{
    #[Route('/author/new', name: 'app_author', methods: ['POST'])]
    public function index(Request $request, SerializerInterface $serializer, AuthorRepository $authorRepository): Response
    {

        $json = $request->getContent();
        $author = $serializer->deserialize($json,Author::class,'json');
        $authorRepository->save($author, true);
        return $this->json('bien envoyé',200);
    }
}
