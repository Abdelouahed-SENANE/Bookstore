<?php


        class BookRepository implements  IBookRepository {
            private object $book;
    
            public function __construct(Book $book)
            {
                $this->book = $book;
            }

            public function store(Book $book)
            {
                $data = [
                    'title' => $book->__get('title'),
                    'ISBN' => $book->__get('ISBN'),
                    'description' => $book->__get('description'),
                    'publishDate' => $book->__get('publishDate'),
                    'bookImage' => $book->__get('bookImage'),
                    'price' => $book->__get('price'),
                    'quantity' => $book->__get('quantity'),
                ];

                $this->book->save($data);
            }

            public function findBookById($bookID)
            {
                return $this->book->findOneByColumn('bookID' , $bookID);
            }
            public function update(Book $book)
            {
                $data = [
                    'title' => $book->__get('title'),
                    'ISBN' => $book->__get('ISBN'),
                    'description' => $book->__get('description'),
                    'publishDate' => $book->__get('publishDate'),
                    'price' => $book->__get('price'),
                ];
                
                if (!empty($book->__get('bookImage'))) {
                    $data['bookImage'] = $book->__get('bookImage');
                }
                $condition = [
                    'bookID' => $book->__get('bookID')
                ];
                $this->book->update($data , $condition);
            }

            public function delete($bookID)
            {
                $this->book->delete('bookID' , $bookID);
            }
            public function searchBooks($column , $value) {
                return $this->book->searchByColumn($column , $value);
            }
        }