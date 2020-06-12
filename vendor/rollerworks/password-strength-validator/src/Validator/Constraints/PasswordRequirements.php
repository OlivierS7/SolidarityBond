<?php

/*
 * This file is part of the RollerworksPasswordStrengthValidator package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\PasswordStrength\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordRequirements extends Constraint
{
    public $tooShortMessage = 'Votre mot de passe doit faire au moins {{length}} caractères.';
    public $missingLettersMessage = 'Votre mot de passe doit inclure au moins une lettre.';
    public $requireCaseDiffMessage = 'Votre mot de passe doit inclure au moins une lettre majuscule et minuscule.';
    public $missingNumbersMessage = 'Votre mot de passe doit inclure au moins un chiffre.';
    public $missingSpecialCharacterMessage = 'Votre mot de passe doit inclure au moins un caractère spécial.';

    public $minLength = 8;
    public $requireLetters = true;
    public $requireCaseDiff = false;
    public $requireNumbers = false;
    public $requireSpecialCharacter = false;
}
