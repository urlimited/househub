<?php

namespace App\Exceptions;

class UnknownGrammarClass extends \Exception
{
    protected $message = 'Unknown grammar class, unable to define database type.';
}
