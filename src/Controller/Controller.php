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
    public function stats(ChartBuilderInterface $chartBuilder): Response
    {
        $rooms = $this->RoomRepository->findAll();
    $roomCategories = [];
    foreach ($rooms as $room) {
        $roomCategories[] = $room->getCatgory();
    }

    $categories = ['Stocks', 'ETFs', 'Mutual Funds', 'Commodities', 'Cryptocurrency'];
    $count = [];

    foreach ($categories as $category) {
        $count[$category] = 0;
    }

    foreach ($roomCategories as $category) {
        if (in_array($category, $categories)) {
            $count[$category]++;
        }
    }
    arsort($count);

    $topRoomCategories = array_slice($count, 0, 3);

    return $this->render('admin/dashboard.html.twig', ['topRoomCategories' => $topRoomCategories]);
    }


}