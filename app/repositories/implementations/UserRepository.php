<?php

class UserRepository implements IUserRepository
{
    /** 
     * @ var user
     */
    private $user;
    /**
     * @ param object user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    // find user by Email ..
    public function getUserByEmail($email)
    {
        try {
            return $this->user->findOneByColumn('email', $email);
        } catch (Exception $e) {
            return  "Error throw database" . $e->getMessage();
        }
    }

    public function findUserById($id)
    {
        try {
            return $this->user->findOneByColumn('userID', $id);
        } catch (Exception $e) {
            return  "Error throw database" . $e->getMessage();
        }
    }

    public function getAllUsers()
    {
        return $this->user->getAll();
    }

    public function getRoleOfUser($id)
    {
        try {
            $sql = "SELECT 
                    CASE 
                        WHEN EXISTS (SELECT 1 FROM customers WHERE customers.userID = users.userID) THEN 'CUSTOMER'
                        WHEN EXISTS (SELECT 1 FROM admins WHERE admins.userID = users.userID) THEN 'ADMIN'
                        ELSE 'null'
                    END AS role
                FROM {$this->user->tablename} 
                WHERE users.userID = ?
                LIMIT 1
            ";
            $statment = $this->user->connection->prepare($sql);
            $statment->execute([$id]);
            $userRole = $statment->fetchColumn();
            return $userRole ?? null;
        } catch (Exception $e) {
            die('Error to fetch role of user' . $e->getMessage());
        }
    }
    public function store(User $user)
    {
        $data = [
            'name' => $user->__get('name'),
            'email' => $user->__get('email'),
            'password' => $user->__get('password')
        ];
        return $this->user->save($data);
    }

    public function update(User $user){
        $data = [
            'name' => $user->__get('name'),
            'email' => $user->__get('email'),
            'password' => $user->__get('password')
        ];
        $condition = [
            'userID' => $user->__get('userID')
        ];
        $this->user->update($data , $condition);
    }

    public function delete($userID){
        return $this->user->delete('userID' , $userID);
    }
}
