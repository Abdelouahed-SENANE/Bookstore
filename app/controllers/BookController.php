<?php
class BookController extends Controller{
    
    use ApiResponse;
    private $repository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->repository = $bookRepository;
    }

    public function addBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookData = [
                'ISBN' => $_POST['ISBN'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'publishDate' => $_POST['publishDate'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
                'categoryID' => $_POST['categoryID']
            ];
            $bookFile = $_FILES['bookImage'] ?? null;
            $validated = validateBookData($bookData);
            $validateImage = uploadImage($bookFile);
            if ($validated['isValid'] && $validateImage === true) {
                $validateData = $validated['data'];
                $newBook = new Book();
                $newBook->__set('ISBN', $validateData['ISBN']);
                $newBook->__set('title', $validateData['title']);
                $newBook->__set('description', $validateData['description']);
                $newBook->__set('publishDate', $validateData['publishDate']);
                $newBook->__set('quantity', $validateData['quantity']);
                $newBook->__set('bookImage', $bookFile['name']);
                $newBook->__set('price', $validateData['price']);
                $newBook->__set('categoryID', $validateData['categoryID']);

                $this->repository->store($newBook);
                $data = ['newBook' => $newBook];
                $this->success($data, 'Book added successfully.');
                return;
            } else {
                $this->error($validated['errors'], 'Invalid book data. Please check your input.', 400);
                return;
            }
        } else {
            $this->error('Invalid request method!', 405);
        }
    }

    /** Update Book Function */
    public function updateBook()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming you have a way to get the book ID for updating
        $bookID = $_POST['bookID'] ?? null;

        // Fetch the existing book data from the repository (assuming it exists)
        $existingBook = $this->repository->findBookById($bookID);
        if (!$existingBook) {
            $this->error('Book not found.', 404);
            return;
        }
        $bookData = [
            'ISBN' => $_POST['ISBN'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'publishDate' => $_POST['publishDate'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity'],
            'categoryID' => $_POST['categoryID']
        ];

        $bookFile = $_FILES['bookImage'] ?? null;

        // Validate book data
        $validated = validateBookData($bookData);

        $validateImage = null;
        if ($bookFile['size'] > 0) { 
            $validateImage = uploadImage($bookFile);
        }
        if ($validated['isValid'] && ($validateImage === true || $validateImage === null)) {
            $validateData = $validated['data'];
            $existingBook->__set('bookID', $bookID);
            $existingBook->__set('ISBN', $validateData['ISBN']);
            $existingBook->__set('title', $validateData['title']);
            $existingBook->__set('description', $validateData['description']);
            $existingBook->__set('publishDate', $validateData['publishDate']);
            $existingBook->__set('categoryID', $validateData['categoryID']);
            if ($validateImage === true) {
                $existingBook->__set('bookImage', $bookFile['name']); 
            }
            $existingBook->__set('price', $validateData['price']);

            $this->repository->update($existingBook);

            $data = ['updatedBook' => $existingBook];
            $this->success($data, 'Book updated successfully.');
            return;
        } else {
            $errors = [];
            if (!$validated['isValid']) {
                $errors['bookData'] = $validated['errors'];
            }
            if ($validateImage !== true && $validateImage !== null) {
                $errors['bookImage'] = $validateImage;
            }
            $this->error($errors, 'Invalid book data or image upload failed. Please check your input.', 400);
            return;
        }
    } else {
        $this->error('Invalid request method!', 405);
    }
}

    /** Delete Book Function */
    public function deleteBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['bookID'])) {
                $bookID = $_POST['bookID'];
                if (!is_numeric($bookID)) {
                    $this->error('Invalid Book ID', 400);
                    return;
                }
                $this->success('Book deleted successfully.');
                return;
            } else {
                $this->error('Book ID not provided', 400);
                return;
            }
        } else {
            $this->error('Invalid request method', 405);
        }
    }

    public function searchBook() {
        if ($_SERVER['METHOD_REQUEST'] === 'GET') {
            if (!isset($_GET['searchBook'])) {
                $this->error('The books not founds', 404);
                return;
            }
            $searchValue = $_GET['searchBook'];
            try {
                $searchByTitle = $this->repository->searchBooks('title' , $searchValue);
                $searchByDesc = $this->repository->searchBooks('description' , $searchValue);
                $result = array_merge($searchByTitle , $searchByDesc);
                $this->success($result , 'Fetched all books successfull' , 200);
                return;
            } catch (Exception $e) {
                $this->error([] , 'Error throw Database' . $e->getMessage() , 500);
                return;
            }
        }
    }
}