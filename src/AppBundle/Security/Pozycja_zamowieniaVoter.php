<?php
namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Entity\Pozycja_zamowienia;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class Pozycja_zamowieniaVoter extends Voter
{
    const VIEW = 'view';
    const ADD = 'add';
    const EDIT = 'edit';
    const DELETE = 'delete';
    
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::ADD, self::EDIT, self::DELETE))) {
            return false;
        }

        if (!$subject instanceof Pozycja_zamowienia) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_ADMIN can do anything! The power!
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        $pozycja = $subject;
        
        switch($attribute){
            case self::VIEW:
                return $this->canView($pozycja, $user, $token);
            case self::ADD:
                return $this->canAdd($pozycja, $user, $token);
            case self::EDIT:
                return $this->canEdit($pozycja, $user, $token);
            case self::DELETE:
                return $this->canDelete($pozycja, $user, $token);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(Pozycja_zamowienia $object, User $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_COOK'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_WAITER'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_MANAGER'))) {
            return true;
        }
        
        return false;
    }
    
    private function canAdd(Pozycja_zamowienia $object, User $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_CLIENT'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_WAITER'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_MANAGER'))) {
            return true;
        }
        
        return false;
    }

    private function canEdit(Pozycja_zamowienia $object, User $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_COOK'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_WAITER'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_MANAGER'))) {
            return true;
        }
        
        return false;
    }
    
    private function canDelete(Pozycja_zamowienia $object, User $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_MANAGER'))) {
            return true;
        }
        
        return false;
    }
}