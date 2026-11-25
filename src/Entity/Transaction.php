<?php

namespace App\Entity;

use App\Enum\TransactionStatus;
use App\Enum\TransactionType;
use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: 'bank_transaction')]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(enumType: \App\Enum\TransactionType::class)]
    private \App\Enum\TransactionType $type = \App\Enum\TransactionType::TRANSFER;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(enumType: \App\Enum\TransactionStatus::class)]
    private \App\Enum\TransactionStatus $status = \App\Enum\TransactionStatus::PENDING;

    #[ORM\ManyToOne(targetEntity: Account::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'RESTRICT')]
    private ?Account $sourceAccount = null;

    #[ORM\ManyToOne(targetEntity: Account::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'RESTRICT')]
    private ?Account $destinationAccount = null;

    #[ORM\Column(length: 34, nullable: true)]
    private ?string $counterpartyIban = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $counterpartyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $counterpartyBank = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'RESTRICT')]
    private ?User $decidedBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $decidedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rejectionReason = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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

    public function getType(): ?TransactionType
    {
        return $this->type;
    }

    public function setType(TransactionType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?TransactionStatus
    {
        return $this->status;
    }

    public function setStatus(TransactionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCounterpartyIban(): ?string
    {
        return $this->counterpartyIban;
    }

    public function setCounterpartyIban(?string $counterpartyIban): static
    {
        $this->counterpartyIban = $counterpartyIban;

        return $this;
    }

    public function getCounterpartyName(): ?string
    {
        return $this->counterpartyName;
    }

    public function setCounterpartyName(?string $counterpartyName): static
    {
        $this->counterpartyName = $counterpartyName;

        return $this;
    }

    public function getCounterpartyBank(): ?string
    {
        return $this->counterpartyBank;
    }

    public function setCounterpartyBank(?string $counterpartyBank): static
    {
        $this->counterpartyBank = $counterpartyBank;

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

    public function getRejectionReason(): ?string
    {
        return $this->rejectionReason;
    }

    public function setRejectionReason(?string $rejectionReason): static
    {
        $this->rejectionReason = $rejectionReason;

        return $this;
    }

    public function getSourceAccount(): ?Account
    {
        return $this->sourceAccount;
    }

    public function setSourceAccount(?Account $sourceAccount): static
    {
        $this->sourceAccount = $sourceAccount;

        return $this;
    }

    public function getDestinationAccount(): ?Account
    {
        return $this->destinationAccount;
    }

    public function setDestinationAccount(?Account $destinationAccount): static
    {
        $this->destinationAccount = $destinationAccount;

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
