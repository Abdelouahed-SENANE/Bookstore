<?php
class CategoryController extends Controller
{
    use ApiResponse;
    private $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryData = [
                'title' => $_POST['title'],
                'description' => $_POST['description']
            ];

            $validated = validateCategoryData($categoryData); 

            if ($validated['isValid']) {
                $validateData = $validated['data'];
                $newCategory = new Category();
                $newCategory->__set('title', $validateData['title']);
                $newCategory->__set('description', $validateData['description']);

                $categoryId = $this->repository->store($newCategory);
                $data = ['newCategory' => $newCategory];
                $this->success($data, 'Category added successfully.');
                return;
            } else {
                $this->error($validated['errors'], 'Invalid category data. Please check your input.', 400);
                return;
            }
        } else {
            $this->error('Invalid request method!', 405);
        }
    }

    public function updateCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryID = $_POST['categoryID'] ?? null;

            $existingCategory = $this->repository->findCategoryById($categoryID);
            if (!$existingCategory) {
                $this->error('Category not found.', 404);
                return;
            }

            $categoryData = [
                'title' => $_POST['title'],
                'description' => $_POST['description']
            ];

            $validated = validateCategoryData($categoryData);

            if ($validated['isValid']) {
                $validateData = $validated['data'];
                $existingCategory->__set('categoryID', $categoryID);
                $existingCategory->__set('title', $validateData['title']);
                $existingCategory->__set('description', $validateData['description']);

                $this->repository->update($existingCategory);

                $data = ['updatedCategory' => $existingCategory];
                $this->success($data, 'Category updated successfully.');
                return;
            } else {
                $this->error($validated['errors'], 'Invalid category data. Please check your input.', 400);
                return;
            }
        } else {
            $this->error('Invalid request method!', 405);
        }
    }

    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['categoryID'])) {
                $categoryID = $_POST['categoryID'];
                if (!is_numeric($categoryID)) {
                    $this->error('Invalid Category ID', 400);
                    return;
                }
                $this->repository->delete($categoryID);
                $this->success('Category deleted successfully.');
                return;
            } else {
                $this->error('Category ID not provided', 400);
                return;
            }
        } else {
            $this->error('Invalid request method', 405);
        }
    }
}
