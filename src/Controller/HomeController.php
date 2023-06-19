<?php

namespace App\Controller;

use App\Entity\Dicton;
use App\Repository\DictonRepository;
use App\Service\languageService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\LocaleSwitcher;

use Faker;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('{_locale}/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request,DictonRepository $dictonRepository, PaginatorInterface $paginator)
    {

        $pagination = $paginator->paginate(
            $dictonRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        // parameters to template
        return $this->render('home/index.html.twig', ['dictons' => $pagination]);
    }
    #[Route('/state', name: 'app_state')]
    public function state( ChartBuilderInterface $chartBuilder )
    {

            $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

            $chart->setData([
                'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                'datasets' => [
                    [
                        'label' => 'My First dataset',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => [0, 10, 5, 2, 20, 30, 45],
                    ],
                ],
            ]);
            $chart->setOptions([
                'scales' => [
                    'y' => [
                        'suggestedMin' => 0,
                        'suggestedMax' => 100,
                    ],
                ],
            ]);

            return $this->render('home/state.html.twig', [
                'chart' => $chart,
            ]);


    }
}
