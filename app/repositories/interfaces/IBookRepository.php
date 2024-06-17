<?php 
    interface IBookRepository {

        public function store(Book $book);
        public function findBookById($bookID);
        public function update(Book $book);
        public function delete(Book $book);
    }