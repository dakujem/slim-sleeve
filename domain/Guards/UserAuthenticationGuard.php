<?php


namespace Domain\Guards;


use Domain\Exceptions\AccessViolation;
use SystemUser;
use User_Model;

/**
 * UserAuthenticationGuard
 */
class UserAuthenticationGuard
{

    const
        NOT_FOUND = 'nf',
        INACTIVE = 'ia',
        BANNED = 'ban';

    /**
     * Instance factory.
     */
    static function i(...$args): self
    {
        return new static(...$args);
    }


    /**
     * Pokial uzivatel nie je opravneny sa prihlasit do systemu, vyhodi vynimku.
     *
     * @param int|string|User_Model|SystemUser $user
     * @return UserAuthenticationGuard
     */
    function protectAuthentication($user): self
    {
        if ($user instanceof SystemUser) {
            $userModel = new User_Model($user->getId());
        } elseif ($user instanceof User_Model) {
            $userModel = $user;
        } elseif (is_numeric($user)) {
            $userModel = new User_Model($user); // user ID
        } elseif (is_string($user)) {
            $userModel = User_Model::getByLogin($user); // username
        } else {
            $userModel = null;
        }

        if (!$userModel instanceof User_Model || $userModel->id <= 0) {
            throw new AccessViolation(_('Účet neexistuje.'), self::NOT_FOUND);
        }
        if (!$userModel->isActive()) {
            throw new AccessViolation(_('Neaktivní účet'), self::INACTIVE);
        }
        if ($userModel->isBanned()) {
            throw new AccessViolation(_('Účet zablokován.'), self::BANNED);
        }

        return $this;
    }
}