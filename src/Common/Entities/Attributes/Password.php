<?php

namespace Studna\Common\Entities\Attributes;

use Nette\Security\Passwords;
use Studna\Common\Exceptions\InvalidPasswordException;

/**
 * Trait Password
 * @package Studna\Common\Entities\Attributes
 */
trait Password {

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=60, nullable=false)
     */
    private $password;

    /**
     * @param $password
     * @param $oldPassword
     * @throws InvalidPasswordException
     */
    public function changePassword($password, $oldPassword)
    {
        if (!$this->verifyPassword($oldPassword))
            throw new InvalidPasswordException;

        $this->setPassword($password);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Passwords::hash($password);
    }

    /**
     * Compare $password to origin
     * @param $password
     * @return bool
     */
    public function verifyPassword($password)
    {

        if (Passwords::verify($password, $this->password)) {
            if (Passwords::needsRehash($this->password)) {
                $this->setPassword($password);
            }

            return TRUE;
        }

        return FALSE;

    }

}