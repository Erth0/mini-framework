<?php 

/**
 * Redirect to a particular path
 */
if (! function_exists('redirect')) {

    function redirect($path) {
        return new \Zend\Diactoros\Response\RedirectResponse($path);
    }
}

/**
 * Returns the base path
 */
if (! function_exists('base_path')) {

    function base_path($path = '') {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

/**
 * Function for getting the enviroment variables
 */
if (! function_exists('env')) {

    function env($key, $default = null) {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case $value === 'true':
                    return true;
                break;
            case $value === 'false':
                return false;
            break;
            
            default:
                return $value;
                break;
        }
    }
}

