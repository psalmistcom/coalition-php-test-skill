<?php

declare(strict_types=1);


namespace Coalition\Exam;


class Skill
{

    private $properties = [];

    public function __call($name, $arguments)
    {
        if (strpos($name, 'has_') === 0) {
            return 'exist';
        }

        return 'not exist';
    }

    public function __get($name)
    {
        // Check if the property ends with '_CT'
        if (substr($name, -3) === '_CT') {
            return isset($this->properties[$name]) ? md5($this->properties[$name]) : null;
        }

        // Return the property as is for other cases
        return $this->properties[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function __toString() {}
}

// Example Usage
$handler = new Skill();

// Test function handling
echo $handler->has_example(); // Output: exist
echo $handler->check_example(); // Output: not exist

// Test property handling
$handler->example_CT = 'sensitive_data';
$handler->example = 'normal_data';

// Access properties
echo $handler->example_CT; // Output: md5 hash of 'sensitive_data'
echo $handler->example;    // Output: normal_data