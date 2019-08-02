<?php

namespace App\Security;

use App\Exception\AccountDeletedException;
use App\Security\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Utilisateur;


class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Utilisateur) {
            return;
        }

        // user is deleted, show a generic Account Not Found message.
        if (!$user->getStatus()) {
            throw new Exception("Ce compte est bloqué");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof Utilisateur) {
            return;
        }

        // user account is expired, the user may be notified
        if ($user->isExpired()) {
            throw new AccountExpiredException('...');
        }
    }
}
