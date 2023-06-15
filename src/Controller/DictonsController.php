<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Dicton;
use App\Repository\AuthorRepository;
use App\Repository\DictonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class DictonsController extends AbstractController
{
    #[Route('/dictons/', name: 'app_dictons', methods: ['GET'])]
    public function index(DictonRepository $dictonsRepository): Response
    {
        return $this->json($dictonsRepository->findAll(),200,[],['groups'=>'dicton:read']);
    }
    #[Route('/dicton/new', name: 'app_dictons_new', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, DictonRepository $dictonRepository ,AuthorRepository $authorRepository): Response
    {

        $json = $request->getContent();

        $dicton = $serializer->deserialize($json,Dicton::class,'json');
        $dicton->setCreatedAt(new \DateTimeImmutable());
        $author=$dicton->getAuthor();

        if(in_array($author,$authorRepository->findAll())){
            $dicton->setAuthor($authorRepository->findOneBy(["name"=>$author->getName()]));
            dd($author);
        }
        else{
            dd($authorRepository->findAll());
        }
        $dictonRepository->save($dicton, true);
        return $this->json('bien envoyé',200);
    }
    #[Route('/dicton/{id}', name: 'app_dictons_show', methods: ['GET'])]
    public function show(Dicton $dicton): Response
    {
        return $this->json($dicton,200,[],['groups'=>'dicton:read']);
    }
    /*
     *         $json = $request->getContent();

        $blague = $serializer->deserialize($json,Blague::class,'json');

        $blagueRepository->save($blague, true);

        return $this->json('bien envoyé',200);
     */
}
