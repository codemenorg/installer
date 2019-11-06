<?php

namespace Codemen\Installer\Services;

class FormValidator
{
    protected $formConfig;

    public function __construct()
    {
        $this->formConfig = config('installer.routes');
    }

    public function validate($request, $fields = [])
    {
        if (empty($fields)) {
            back()->withInput()->send();
        }

        $rules = [];
        $messages = [];
        foreach ($fields as $item => $options) {
            $rules[$item] = $options['validation'];
            if (isset($options['messages'])) {
                $messages[$item] = $options['messages'];
            }
        }

        return $request->validate($rules, $messages);

    }

}
