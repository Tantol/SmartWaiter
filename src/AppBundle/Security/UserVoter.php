<?php
namespace AppBundle\Security;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class UserVoter extends Voter
{
    const VIEW = 'view';
    const ADD = 'add';
    const EDIT = 'edit';
    const DELETE = 'delete';
    const CHANGE = 'change';
    
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::ADD, self::EDIT, self::DELETE, self::CHANGE))) {
            return false;
        }

        // only vote on User objects inside this voter
        if (!$subject instanceof User) {
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
        $userObject = $subject;
        
        switch($attribute){
            case self::VIEW:
                return $this->canView($userObject, $user, $token);
            case self::ADD:
                return $this->canAdd($userObject, $user, $token);
            case self::EDIT:
                return $this->canEdit($userObject, $user, $token);
            case self::DELETE:
                return $this->canDelete($userObject, $user, $token);
            case self::CHANGE:
                return $this->canChange($userObject, $user, $token);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(User $object, User $user, TokenInterface $token)
    {
        return false;
    }
    
    private function canAdd(User $object, User $user, TokenInterface $token)
    {
        return false;
    }

    private function canEdit(User $object, User $user, TokenInterface $token)
    {
        return false;
    }
    
    private function canDelete(User $object, User $user, TokenInterface $token)
    {
        if ($user === $object) {
            return true;
        }
        
        return false;
    }
    
    private function canChange(User $object, User $user, TokenInterface $token)
    {
        if ($user === $object) {
            return true;
        }
        
        return false;
    }
}  
