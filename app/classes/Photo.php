<?php

class Photo
{
    public static function prepare($file = null)
    {
        if (!empty($file)) {
            $photo = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $photo);
            return $photo;
        } else {
            return 'no_photo.jpg';
        }
    }
}
