<?php

namespace App\Entity;

use App\Enum\AccountStatus;
use App\Enum\AccountType;
use App\Repository\AccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 34, unique: true)]
    private ?string $iban = null;

    #[ORM\Column(enumType: \App\Enum\AccountType::class)]
    private \App\Enum\AccountType $type = \App\Enum\AccountType::CHECKING;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2)]
    private string $balance = '0.00';

    #[ORM\Column(length: 3)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $openedAt = null;

    #[ORM\Column(enumType: \App\Enum\AccountStatus::class)]
    private \App\Enum\AccountStatus $status = \App\Enum\AccountStatus::PENDING;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $scoreUpdatedAt = null;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'RESTRICT')]
    private ?Customer $customer = null;

    public function __construct()
    {
        $this->openedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): static
    {
        $this->iban = $iban;

        return $this;
    }

    public function getType(): ?AccountType
    {
        return $this->type;
    }

    public function setType(AccountType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getOpenedAt(): ?\DateTimeImmutable
    {
        return $this->openedAt;
    }

    public function setOpenedAt(\DateTimeImmutable $openedAt): static
    {
        $this->openedAt = $openedAt;

        return $this;
    }

    public function getStatus(): ?AccountStatus
    {
        return $this->status;
    }

    public function setStatus(AccountStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getScoreUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->scoreUpdatedAt;
    }

    public function setScoreUpdatedAt(?\DateTimeImmutable $scoreUpdatedAt): static
    {
        $this->scoreUpdatedAt = $scoreUpdatedAt;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }
}
