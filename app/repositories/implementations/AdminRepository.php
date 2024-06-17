<?php 
    class AdminRepository implements IAdminRepository {
        private $repository;

        public function __construct(Admin $admin)
        {
            $this->repository = $admin;
        }
        public function store(Admin $admin)
        {
            $data = [
                'userID' => $admin->__get('userID')
            ];
            $this->repository->save($data);
        }
    }