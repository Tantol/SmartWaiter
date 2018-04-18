<?php
namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Entity\Skladnik;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class SkladnikVoter extends Voter
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

        if (!$subject instanceof Skladnik) {
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

        $skladnik = $subject;
        
        switch($attribute){
            case self::VIEW:
                return $this->canView($skladnik, $user, $token);
            case self::ADD:
                return $this->canAdd($skladnik, $user, $token);
            case self::EDIT:
                return $this->canEdit($skladnik, $user, $token);
            case self::DELETE:
                return $this->canDelete($skladnik, $user, $token);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(Skladnik $object, User $user, TokenInterface $token)
    {
        return false;
    }
    
    private function canAdd(Skladnik $object, User $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_COOK'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_MANAGER'))) {
            return true;
        }
        
        return false;
    }

    private function canEdit(Skladnik $object, User $user, TokenInterface $token)
    { 
        return false;
    }
    
    private function canDelete(Skladnik $object, User $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_COOK'))) {
            return true;
        } else if ($this->decisionManager->decide($token, array('ROLE_MANAGER'))) {
            return true;
        }
        
        return false;
    }
}