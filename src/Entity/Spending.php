<?php

namespace App\Entity;

use App\Repository\SpendingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpendingRepository::class)
 */
class Spending
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_by_instalment;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $instalment_amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $instalment_ending_date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPaid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_fixed_cost;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $payDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_instalments;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $instalment_ispaid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsByInstalment(): ?bool
    {
        return $this->is_by_instalment;
    }

    public function setIsByInstalment(bool $is_by_instalment): self
    {
        $this->is_by_instalment = $is_by_instalment;

        return $this;
    }

    public function getInstalmentAmount(): ?float
    {
        return $this->instalment_amount;
    }

    public function setInstalmentAmount(?float $instalment_amount): self
    {
        $this->instalment_amount = $instalment_amount;

        return $this;
    }

    public function getInstalmentEndingDate(): ?\DateTimeInterface
    {
        return $this->instalment_ending_date;
    }

    public function setInstalmentEndingDate(?\DateTimeInterface $instalment_ending_date): self
    {
        $this->instalment_ending_date = $instalment_ending_date;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getIsFixedCost(): ?bool
    {
        return $this->is_fixed_cost;
    }

    public function setIsFixedCost(bool $is_fixed_cost): self
    {
        $this->is_fixed_cost = $is_fixed_cost;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPayDate(): ?\DateTimeInterface
    {
        return $this->payDate;
    }

    public function setPayDate(\DateTimeInterface $payDate): self
    {
        $this->payDate = $payDate;

        return $this;
    }

    public function getNbInstalments(): ?int
    {
        return $this->nb_instalments;
    }

    public function setNbInstalments(?int $nb_instalments): self
    {
        $this->nb_instalments = $nb_instalments;

        return $this;
    }

    public function getInstalmentIspaid(): ?bool
    {
        return $this->instalment_ispaid;
    }

    public function setInstalmentIspaid(bool $instalment_ispaid): self
    {
        $this->instalment_ispaid = $instalment_ispaid;

        return $this;
    }
}
