<?php


namespace Codemen\Installer\Requests;


use Illuminate\Config\Repository;

class FormRequest extends BaseRequest
{
    protected $routeConfig = [];
    private $messages = [];
    private $rules = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setRouteConfig();
        $fields = $this->routeConfig['fields'] ?? [];
        foreach ($fields as $item => $options) {
            $this->rules[$item] = $options['validation'];
            if (isset($options['messages'])) {
                $this->messages[$item] = $options['messages'];
            }
        }
        return $this->rules;
    }

    public function messages()
    {
        return $this->messages;
    }

    /**
     * @return mixed
     */
    public function getRouteConfig()
    {
        return $this->routeConfig;
    }

    /**
     * @param mixed $routeConfig
     * @return array|Repository|mixed
     */
    public function setRouteConfig(array $routeConfig = [])
    {
        if (empty($routeConfig)) {
            $routeConfig = config('installer.routes.' . $this->route('types'));
        }
        return $this->routeConfig = $routeConfig;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function passedValidation()
    {
        $validators = $this->routeConfig['validator'] ?? [];
        if (empty($validators)) {
            return true;
        }

        $isValid = true;
        $message = '';

        if (is_array($validators)) {
            foreach ($validators as $validator) {
                $validateClass = app($validator);
                $isValid = $validateClass->validate($this);
                if (!$isValid) {
                    $message = $validateClass->message();
                    break;
                }
            }
        } else {
            $validateClass = app($validators);
            $isValid = $validateClass->validate($this);
            if (!$isValid) {
                $message = $validateClass->message();
            }
        }

        if (!$isValid) {
            return back()->withInput()->with('error', $message)->send();
        }

    }

}
