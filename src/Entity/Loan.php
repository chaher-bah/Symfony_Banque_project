<?php

namespace App\Entity;

use App\Enum\LoanStatus;
use App\Repository\LoanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private ?string $interestRate = null;

    #[ORM\Column]
    private ?int $durationMonths = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $requestedAt = null;

    #[ORM\Column]
    private ?int $scoreAtRequest = null;

    #[ORM\Column(enumType: \App\Enum\LoanStatus::class)]
    private \App\Enum\LoanStatus $status = \App\Enum\LoanStatus::PENDING;

    #[ORM\ManyToOne(targetEntity: Account::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'RESTRICT')]
    private ?Account $account = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'RESTRICT')]
    private ?User $decidedBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $decidedAt = null;

    public function __construct()
    {
        $this->requestedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getInterestRate(): ?string
    {
        return $this->interestRate;
    }

    public function setInterestRate(string $interestRate): static
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getDurationMonths(): ?int
    {
        return $this->durationMonths;
    }

    public function setDurationMonths(int $durationMonths): static
    {
        $this->durationMonths = $durationMonths;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeImmutable $requestedAt): static
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getScoreAtRequest(): ?int
    {
        return $this->scoreAtRequest;
    }

    public function setScoreAtRequest(int $scoreAtRequest): static
    {
        $this->scoreAtRequest = $scoreAtRequest;

        return $this;
    }

    public function getStatus(): ?LoanStatus
    {
        return $this->status;
    }

    public function setStatus(LoanStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDecidedAt(): ?\DateTimeImmutable
    {
        return $this->decidedAt;
    }

    public function setDecidedAt(?\DateTimeImmutable $decidedAt): static
    {
        $this->decidedAt = $decidedAt;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getDecidedBy(): ?User
    {
        return $this->decidedBy;
    }

    public function setDecidedBy(?User $decidedBy): static
    {
        $this->decidedBy = $decidedBy;

        return $this;
    }
}
