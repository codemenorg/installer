<?php


namespace Codemen\Installer\Validators;


use Codemen\Installer\Requests\FormRequest;

abstract class Validator
{
    abstract public function validate(FormRequest $request);

    abstract public function message();
}
