<?php

namespace App\Controller;

use App\Entity\Income;
use App\Entity\Spending;
use App\Form\IncomeType;
use App\Form\SpendingType;
use App\Manager\SpendingManager;
use App\Service\CalendarService;
use App\Repository\SpendingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpendingController extends AbstractController
{
    /**
     * @Route("/current-month", name="currentMonth")
     */
    public function displayCurrentMonth(CalendarService $calendar, SpendingRepository $repo)
    {
        // update spending set spending.is_paid = 0 where is_fixed_cost = 1


        $em = $this->getDoctrine()->getManager();

        
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $month = date('m');
        $income =  $this->getDoctrine()->getRepository(Income::class)->findByPayDate(date('m'));

        $qb = $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\Spending', 'u')
            ->where('u.is_fixed_cost = 1')
        ;
        $fixedSpendings = $qb->getQuery()->getResult();

        $query = $em->createQueryBuilder()
        ->select('u')
        ->from('App\Entity\Spending', 'u')
        ->where('u.is_fixed_cost = 0')
    ;
    $variableSpendingsOfTheMonth = $query->getQuery()->getResult();

    $findSpendingsPaidByInstalment = $repo->findSpendingsPaidByInstalment();

        return $this->render('spending/current_month.html.twig', [
            'fixedSpendings' => $fixedSpendings,
            'variableSpendings' => $variableSpendingsOfTheMonth,
            'spendingsPaidByInstalment' => $findSpendingsPaidByInstalment,
            'income' => $income
        ]);
    }

    /**
     * @Route("/spending-add", name="addSpending")
     */
    public function addSpending(Request $request)
    {
        $spending = new Spending();
        $form = $this->createForm(SpendingType::class, $spending);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $spending = $form->getData();
            $date = $spending->getDate()->format('Y-m-d');
            $nbInstalments = $spending->getNbInstalments();

            // We substract 1 to the number of instalments because there is always a first payment
            $nbInstalments+-1;

            if($spending->getIsByInstalment())
             {
                $instalmentAmount = $spending->getAmount() / $spending->getNbInstalments();
                $spending->setInstalmentAmount($instalmentAmount);

                // Auto calculate the ending date using the number of instalments of the spending
                $ending_date = date_modify(new \Datetime,"+".$nbInstalments."Month");
                $spending->setInstalmentEndingDate($ending_date);
             }

            $spending->setPayDate(new \Datetime($date));
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($spending);
            $entityManager->flush();
    
            return $this->redirectToRoute('home');
        }
        return $this->render('spending/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/spendings", name="spendings")
     */
    public static function getAllSpendings() {

    
    }

    /**
     * @Route("/income/add", name="add_income")
     */
    public function addIncome(Request $request) {

        $income = new Income();
        $form = $this->createForm(IncomeType::class, $income);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
   
            $income = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($income);
            $entityManager->flush();
    
            return $this->redirectToRoute('home');
        }

        return $this->render('spending/add_income.html.twig', [
            'form' => $form->createView(),
        ]);
        
    }

    /**
     * @Route("/spendings/set_is_paid", name="spending_set_is_paid", condition="request.isXmlHttpRequest()", methods={"POST"})
     * @param Request $request
     * @param SpendingManager $manager
     * @param SpendingRepository $repository
     * @return RedirectResponse|Response
     */
    public function spendingSetIsPaid(Request $request, SpendingManager $manager, SpendingRepository $repository)
    {
       
        $target = $request->request->get('id', null);   
        $val = $request->request->get('val', false);
        $target = $repository->findById($target);
        $target->setIsPaid($val);

        $manager->update($target);
        
        return new JsonResponse(
            [
                'success' => true,
                'message' => "Statut de la dépense mis à jour",
                'val' => $val,
            ]
        );
    }

}
