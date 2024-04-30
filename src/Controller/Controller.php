<?php

namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\RoomRepository;

#[Route('/')]
class Controller extends AbstractController
{
    private $RoomRepository; 

    public function __construct(RoomRepository $roomrep)
    {
        $this->RoomRepository = $roomrep;
    }

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function stats(ChartBuilderInterface $chartBuilder, RoomRepository $roomRepository): Response
    {
        $roomCounts = $roomRepository->getRoomCountsPerCategory();    
        // Extract the top 3 categories
        arsort($roomCounts);
        $topRoomCategories = array_slice($roomCounts, 0, 3);
        dump($topRoomCategories);
        
        $chart = $chartBuilder->createChart(Chart::TYPE_PIE);
        
        $data = [
            'labels' => array_keys($topRoomCategories), 
            'datasets' => [
                [
                    'label' => 'Room Categories',
                    'backgroundColor' => ['#00cca2', '#8d16e8', '#ef764c'],
                    'data' => array_values($topRoomCategories),
                ],
            ],
        ];
        
        $chart->setData($data);
    
        // Add any custom options here if needed
    
        return $this->render('admin/dashboard.html.twig', [
            'chart' => $chart,
        ]);
    }


}