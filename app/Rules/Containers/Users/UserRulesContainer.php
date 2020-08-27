<?php


namespace App\Rules\Containers\Users;


use App\Lib\ValidationGenerator;

abstract class UserRulesContainer
{
    protected ValidationGenerator $validationGenerator;

    public function __construct(ValidationGenerator $validationGenerator)
    {
        $this->validationGenerator = $validationGenerator;
    }

    public function getRules(): array
    {
        return $this->validationGenerator->buildManyRules(
            [
                "{$this->nameAttr()}|{$this->surnameAttr()}|{$this->patronymicAttr()}" => 'required|min:2|max:255',

                ($this->usernameAttr()) => 'required|string|min:5|max:255',
                ($this->passwordAttr()) => 'string'
            ]
        );
    }

    public function nameAttr(): string
    {
        return 'name';
    }

    public function surnameAttr(): string
    {
        return 'surname';
    }

    public function patronymicAttr(): string
    {
        return 'patronymic';
    }

    public function usernameAttr(): string
    {
        return 'email';
    }

    public function passwordAttr(): string
    {
        return 'password';
    }
}
