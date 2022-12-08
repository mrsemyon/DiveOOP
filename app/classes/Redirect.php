<?php

class Redirect
{
    public static function to(string $location, array $parameters = null): void
    {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case '404':
                        header('HTTP/1.0 404 Not Found');
                        require $_SERVER['DOCUMENT_ROOT'] . '/404.php';
                        exit;
                        break;
                }
            }
            if ($parameters) {
                $get = '?';
                foreach ($parameters as $key => $value) {
                    $get .= $key . '=' . $value;
                }
            }
            header('Location:' . $location . '.php' . $get);
        }
    }
}
