<?php

namespace Codemen\Installer\Services;

use Exception;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param $variables
     * @return string
     */
    public function save(array $variables)
    {
        if (empty($variables)) {
            back()->withInput()->send();
        }

        try {
            $variables = array_change_key_case($variables, CASE_UPPER);

            $env = $this->getEnvContent();

            // Split string on every " " and write into array
            $env = preg_split('/\n/', $env);
            // Loop through given data
            foreach ($variables as $key => $value) {
                // Loop through .env-data
                $isKeyMatch = false;
                foreach ($env as $envKey => $envValue) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $envValue, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $value = preg_match("/\\s/", $value) ? '"' . $value . '"' : $value;
                        $env[$envKey] = $key . "=" . (is_bool($value) ? json_encode($value) : $value);
                        $isKeyMatch = true;
                        break;
                    }/* else {
                        // If not, keep the old one
                        $env[$envKey] = $envValue;
                    }*/
                }

                if ($isKeyMatch === false) {
                    $env[] = $key . "=" . (is_bool($value) ? json_encode($value) : $value);
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents($this->envPath, $env);
        } catch (Exception $exception) {
            back()->withInput()->send();
        }
    }

    /**
     * Get the content of the .env file.
     * @return string
     */
    public function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }
}
