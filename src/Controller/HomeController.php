<?php

namespace App\Controller;

use App\Entity\Income;
use App\Entity\Spending;
use App\Service\CalendarService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CalendarService $calendar)
    {
        $date = new \DateTime();
        
        $spendingsOfTheDay = $this->getDoctrine()->getRepository(Spending::class)->findByDate($date);
        $paidSpendings = $this->getDoctrine()->getRepository(Spending::class)->findPaidSpendings(date('m'));
        $leftspendings =  $this->getDoctrine()->getRepository(Spending::class)->findUnpaidSpendings(date('m'));
        $income =  $this->getDoctrine()->getRepository(Income::class)->findByPayDate(date('m'));
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'spendings' => $spendingsOfTheDay,
            'paidSpendings' => $paidSpendings,
            'leftspendings' => $leftspendings,
            'income'        => $income
        ]);
    }
}
