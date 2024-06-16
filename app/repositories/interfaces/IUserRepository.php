
<?php 

interface IUserRepository {
    public function getUserByEmail($email);
    public function findUserById($id);
    public function getAllUsers();
    public function getRoleOfUser($id);
    public function store(User $user);
    public function update(User $user);
    public function delete($userID);
}