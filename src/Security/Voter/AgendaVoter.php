<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AgendaVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['AGENDA_EDIT', 'AGENDA_VIEW'])
            && $subject instanceof \App\Entity\Agenda;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (!$this->security->isGranted('ROLE_USER')) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'AGENDA_EDIT':
                // logic to determine if the user can EDIT
                return $subject->getUser()->getId() === $user->getId();
                break;
            case 'AGENDA_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
