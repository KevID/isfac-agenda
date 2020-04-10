<?php

namespace App\Entity;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Votre ancien mot de passe n'est pas correct"
     * )
     * @Assert\Type("string")
     */
    protected $oldPassword;

    /**
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Votre mot de passe doit contenir minimum {{ limit }} caractères",
     *      maxMessage = "Votre mot de passe ne doit pas dépasser {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    protected $password;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
