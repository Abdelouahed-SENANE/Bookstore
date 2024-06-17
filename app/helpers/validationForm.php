<?php

function validateUserData(array $userData) {
    $errors = ['errName' => '', 'errEmail' => '', 'errPassword' => ''];
    $name = htmlspecialchars($userData['name'] ?? '');
    $email = htmlspecialchars($userData['email'] ?? '');
    $password = htmlspecialchars($userData['password'] ?? '');

    if (empty($name)) {
        $errors['errName'] = 'Name is required!';
    } elseif (strlen($name) < 10) {
        $errors['errName'] = 'Name must be at least 10 characters!';
    }else {
        $errors['errName'] = '';
    }

    if (empty($email)) {
        $errors['errEmail'] = 'Email is required!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['errEmail'] = 'Invalid email format!';
    }else {
        $errors['errEmail'] = '';
    }

    if (empty($password)) {
        $errors['errPassword'] = 'Password is required!';
    } elseif (strlen($password) < 8) {
        $errors['errPassword'] = 'Password must be at least 8 characters!';
    }else {
        $errors['errPassword'] = '';
    }

    $hasErrors = array_filter($errors);

    if (!$hasErrors) {
        return [
            'isValid' => true,
            'data' => [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
        ];
    } else {
        return [
            'isValid' => false,
            'errors' => $errors,
        ];
    }
}


function validateBookData($data)
{
    $errors = ['errBookID' => '', 'errISBN' => '', 'errTitle' => '', 'errDescription' => '', 'errPublishDate' => '', 'errBookImage' => '', 'errPrice' => ''];
    $validatedData = [];
    if (empty($data['ISBN']) || !is_numeric($data['ISBN'])) {
        $errors['errISBN'] = 'ISBN must be a number.';
    } else {
        $validatedData['ISBN'] = htmlspecialchars($data['ISBN']);
    }
    if (empty($data['title'])) {
        $errors['errTitle'] = 'Title is required.';
    } else {
        $validatedData['title'] = htmlspecialchars($data['title']);
    }
    if (empty($data['description'])) {
        $errors['errDescription'] = 'Description is required.';
    } else {
        $validatedData['description'] = htmlspecialchars($data['description']);
    }
    if (empty($data['publishDate']) || !DateTime::createFromFormat('Y-m-d', $data['publishDate'])) {
        $errors['errPublishDate'] = 'Publish Date must be in YYYY-MM-DD format.';
    } else {
        $validatedData['publishDate'] = htmlspecialchars($data['publishDate']);
    }

    if (empty($data['price']) || !is_numeric($data['price'])) {
        $errors['errPrice'] = 'Price must be a number.';
    } else {
        $validatedData['price'] = htmlspecialchars($data['price']);
    }
    $hasErrors = array_filter($errors);

    if (!$hasErrors) {
        return [
            'isValid' => true,
            'data' => $validatedData,
        ];
    } else {
        return [
            'isValid' => false,
            'errors' => $errors,
        ];
    }
}

function validateImage($imageFile) {
    $errImage = '';
    $allow_extension = [
        'jpg',
        'png',
        'jpeg'
    ];
    $fileExtension = pathinfo($imageFile['imageBook']['name'] , PATHINFO_EXTENSION);

    if (!in_array(strtolower($fileExtension) , $allow_extension)) {
         $errImage = "Upload valid images. Only PNG and JPEG , JPG are allowed.";
         return $errImage;
    }else if ($imageFile['imageBook']['size'] > 2000000) {
        $errImage = 'Image size exceeds 2MB';
        return $errImage;
    }else {
        $errImage = '';
        return $errImage;
    }
    return $errImage;
}

function uploadImage($file) {
    $stock_img = $_SERVER["DOCUMENT_ROOT"]."/Bookstore/public/assets/upload/";
    $validateImage = validateImage($file);
    if (!empty($validateImage)) {
        return $validateImage;
    }
    
    $file_name = basename($file['imageBook']['name']);
    $placement = $stock_img.$file_name;
    
    if (move_uploaded_file($file['tmp_name'], $placement)) {
        return true;
    } else {
        return false;
    }
}

function validateCategoryData($data)
{
    $errors = ['errTitle' => '', 'errDescription' => ''];
    $validatedData = [];

    if (empty($data['title'])) {
        $errors['errTitle'] = 'Title is required.';
    } else {
        $validatedData['title'] = htmlspecialchars($data['title']);
    }

    if (empty($data['description'])) {
        $errors['errDescription'] = 'Description is required.';
    } else {
        $validatedData['description'] = htmlspecialchars($data['description']);
    }

    $hasErrors = array_filter($errors);

    if (!$hasErrors) {
        return [
            'isValid' => true,
            'data' => $validatedData,
        ];
    } else {
        return [
            'isValid' => false,
            'errors' => $errors,
        ];
    }
}

