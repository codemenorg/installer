<?php

namespace Codemen\Installer\Services;

use Illuminate\Support\HtmlString;
use Illuminate\Support\MessageBag;

class FormGenerator
{
    protected $errors;
    protected $formConfig;

    public function __construct()
    {
        $this->formConfig = config('installer.groups');
        $this->errors = session()->has('errors') ? session()->get('errors')->getBag('default') : new MessageBag();
    }

    /**
     * @param array $fields
     * @param $route
     * @param string $method
     * @return string
     */
    public function generate($fields = [], $route = '/', $method = 'post')
    {
        $formFields = '';
        foreach ($fields as $filedName => $options) {
            $functionName = '_' . $options['field_type'];
            $formFields .= $this->{$functionName}($filedName, $options);
        }

        $formOpen = '<form action="' . $route . '" method="' . $method . '">' .
            '<input type="hidden" name="_token" value="' . csrf_token() . '" />';
        $formClose = '<div class="form-group">' .
            '<button class="button block mt-35" type="submit">' . 'Next ' .
            '<i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>' .
            '</button>' .
            '</form>';

        return new HtmlString($formOpen . $formFields . $formClose);
    }

    private function _text($fieldName, $options)
    {
        $errorClass = $textError = '';
        if ($this->errors->has($fieldName)) {
            $textError = '<span class="help-block">' . $this->errors->first($fieldName) . '</span>';
            $errorClass = ' has-error';
        }
        $placeholder = $options['placeholder'] ?? '';
        $textOpen = '<div class="form-group' . $errorClass . '">';
        $textField = '<label for="' . $fieldName . '">' . $options['field_label'] . '</label>' .
            '<input type="text" class="form-control" name="' . $fieldName . '" value="' . $this->getValue($fieldName)
            . '" placeholder="' . $placeholder . '" />';


        $textEnd = '</div>';

        return $textOpen . $textField . $textError . $textEnd;

    }

    private function getValue($fieldName)
    {
        return old($fieldName, env(strtoupper($fieldName)));
    }

    private function _select($fieldName, $options)
    {
        $errorClass = $selectError = '';
        if ($this->errors->has($fieldName)) {
            $selectError = '<span class="help-block">' . $this->errors->first($fieldName) . '</span>';
            $errorClass = ' has-error';
        }
        $selectOpen = '<div class="form-group' . $errorClass . '">' .
            '<label for="' . $fieldName . '">' . $options['field_label'] . '</label>' .
            '<div class="no-select">' .
            '<select name="' . $fieldName . '" class="form-control" id="' . $fieldName . '">';
        $selectOptions = '';
        $savedValue = $this->getValue($fieldName);
        foreach ($options['field_value'] as $value => $label) {
            $selected = $savedValue == $value ? "selected" : "";
            $selectOptions .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
        }

        $selectEnd = '</select></div>' . $selectError .
            '</div>';

        return $selectOpen . $selectOptions . $selectEnd;
    }

    private function _switch($fieldName, $options)
    {
        $errorClass = $switchError = '';
        if ($this->errors->has($fieldName)) {
            $switchError = '<span class="help-block">' . $this->errors->first($fieldName) . '</span>';
            $errorClass = ' has-error';
        }

        $switchOpen = '<div class="form-group' . $errorClass . '">' .
            '<label for="' . $fieldName . '">' . $options['field_label'] . '</label>' .
            '<div class="cm-switch">';
        $savedValue = json_encode(boolval($this->getValue($fieldName)));
        $switchFields = '';
        foreach ($options['field_value'] as $value => $label) {
            $checked = ($savedValue === $value) ? 'checked' : '';
            $switchFields .= '<input id="' . $fieldName . '-' . $value . '" class="cm-switch-input" type="radio" name="' . $fieldName . '" value="' . $value . '" ' . $checked . '/>' .
                '<label for="' . $fieldName . '-' . $value . '" class="cm-switch-label">' . $label . '</label>';
        }

        $switchEnd = '</div >' . $switchError . '</div >';
        return $switchOpen . $switchFields . $switchEnd;
    }
}
