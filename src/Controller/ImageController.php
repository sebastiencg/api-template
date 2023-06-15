<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[Route('/api')]
class ImageController extends AbstractController
{
    #[Route('/image/upload', name: 'app_image')]
    public function index(UploaderHelper $helper,Request $request, EntityManagerInterface $manager): Response
    {

        $image = new Image();

        $file = $request->files->get('monImage');

        $image->setImageFile($file);

        $manager->persist($image);
        $manager->flush();


        $response = [
            "message"=>"bravo pour ton upload",
            "idImage"=>$image->getId(),
            "image"=>"https://localhost:8000".$helper->asset($image)

        ];



        return $this->json($response,200);    }
}
