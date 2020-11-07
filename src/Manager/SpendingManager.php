<?php

namespace App\Manager;


use App\Entity\Spending;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SpendingManager
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var UrlGeneratorInterface */
    private $generator;
//    /** @var DatatableManager */
//    private $datatableManager;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $generator)
    {
        $this->em               = $em;
        $this->generator        = $generator;
//        $this->datatableManager = $datatableManager;
    }

    public function create(Spending $spending)
    {
        $spending->setCreatedAt(new \DateTime());

        $this->em->persist($spending);
        $this->em->flush();
    }

    public function update(Spending $spending)
    {
        $spending->setUpdatedAt(new \DateTime());

        $this->em->flush();
    }

    /**
     * @param Spending $spending
     * @throws \Exception
     */
    public function delete(Spending $spending): void
    {
        $spending->setDeletedAt(new \DateTime());
        $this->persist($spending);

        $this->em->flush();
    }

    /**
     * @param Spending $spending
     */
    private function persist(Spending $spending)
    {
        $this->em->persist($spending);
        $this->em->flush();
    }

}