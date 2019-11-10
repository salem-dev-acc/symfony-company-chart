<?php

namespace App\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ExistsInDatabase extends Constraint
{
    public $message = 'The value "{{ string }}" does not exist in database';
}
