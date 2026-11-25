<?php

namespace App\Security;

use App\Entity\User;
use App\Enum\UserStatus;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if ($user instanceof User && $user->getStatus() !== UserStatus::ACTIVE) {
            throw new CustomUserMessageAccountStatusException('Votre inscription doit être approuvée avant la connexion.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
