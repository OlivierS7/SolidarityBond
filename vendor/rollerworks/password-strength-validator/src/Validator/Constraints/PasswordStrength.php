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
class PasswordStrength extends Constraint
{
    public $tooShortMessage = 'Votre mot de passe doit faire au moins {{length}} caractères.';
    public $message = 'Votre mot de passe est trop faible.';
    public $minLength = 8;
    public $minStrength;
    public $unicodeEquality = false;

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'minStrength';
    }

    public function getRequiredOptions()
    {
        return ['minStrength'];
    }
}
