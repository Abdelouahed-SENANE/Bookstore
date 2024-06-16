<?php
trait ApiResponse
{
    public function success($data = [], $message = '', $code = 200)
    {
        $response = json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'code' => $code
        ]);
        header('Content-Type: application/json');
        echo($response);
    }

    public function error($errors = [] , string $message = '', $code = 400)
    {
        $response = json_encode([
            'status' => 'failed',
            'message' => $message,
            'errors' => $errors,
            'code' => $code
        ]);
        header('Content-Type: application/json');
        echo($response);
    }
}
