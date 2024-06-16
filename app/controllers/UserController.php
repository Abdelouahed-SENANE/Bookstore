
<?php
    require_once APPROOT . '/helpers/validationForm.php';

class UserController extends Controller
{
    use ApiResponse;
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /** Login Function */
    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);

            $user = $this->userRepository->getUserByEmail($email);
            if (!$user) {
                $this->error($errors = [] ,'Your credentials are not correct', 400);
                return;
            }
            if (password_verify($password, $user->password)) {
                $_SESSION['user'] = [
                    'userID' => $user->userID,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $this->userRepository->getRoleOfUser($user->userID)
                ];
                $this->success($_SESSION['user'], 'User Logged succefully', 200);
                return;
            } else {
                $this->error($errors = [] ,'Your password is not correct', 400);
                return;

            }
        }
    }

    /** Registration Function */
    public function register()
    {
        if ($_SERVER['METHOD_REQUEST'] == 'POST') {
            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            ];
            $validated = validateUserData($userData);
            if ($validated['isValid']) {
                $validateData = $validated['data'];
                $newUser = new User();
                $newUser->__set($validateData['name'] , 'name');
                $newUser->__set($validateData['email'] , 'email');
                $newUser->__set($validateData['password'] , 'password');
                $this->userRepository->store($newUser);
                $data = ['newUser' => $newUser];
                $this->success($data, 'User Registred succefully.');
                return;
            }else{
                 $this->error($validated['errors'] , 'Invalid registration data. Please check your input.' , 400);
                return;

            }
        }else {
            $errors['request'] = 'Invalid request method!';
        }
    }


    /** Update user from Database */
    public function updateUser(){
        if ($_SERVER['METHOD_REQUEST'] === "POST") {
            $userUpdateData =  [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            ];
            $validated = validateUserData($userUpdateData);
            if ($validated['isValid']) {
                $validateData = $validated['data'];
                $updateUser = new User();
                $updateUser->__set($_POST['userID'] , 'userID');
                $updateUser->__set($validateData['name'] , 'name');
                $updateUser->__set($validateData['email'] , 'email');
                $updateUser->__set($validateData['password'] , 'password');
                $this->userRepository->update($updateUser);
                $data = ['updateUser' => $updateUser];
                $this->success($data, 'User Updated succefully.');
                return;
            }else{
                $this->error($validated['errors'] , 'Check inputs, we cannot update data' , 400);
               return;
           }
        }
    }

    public function deleteUser(){
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['userID'])) {
                $userID = $_POST['userID'];
                if (!is_numeric($userID)) {
                    $this->error('Invalid User ID', 400);
                    return;
                }
                    $this->userRepository->delete($userID);
                    $this->success('User deleted successfully.');
            } else {
                $this->error('User ID not provided', 400);
            }
        } else {
            $this->error('Invalid request method', 405);
        }
    }
}
