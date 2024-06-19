<?php 
    class AdminRepository implements IAdminRepository {
        private $admin;

        public function __construct(Admin $admin)
        {
            $this->admin = $admin;
        }
        public function store(Admin $admin)
        {
            $data = [
                'userID' => $admin->__get('userID')
            ];
            $this->admin->save($data);
        }
    }