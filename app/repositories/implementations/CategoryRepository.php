<?php

class CategoryRepository implements ICategoryRepository
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function findCategoryById($id)
    {
        try {
            return $this->category->findOneByColumn('categoryID', $id);
        } catch (Exception $e) {
            return "Error through database: " . $e->getMessage();
        }
    }

    public function getAllCategories()
    {
        return $this->category->getAll();
    }

    public function store(Category $category)
    {
        $data = [
            'title' => $category->__get('title'),
            'description' => $category->__get('description')
        ];
        return $this->category->save($data);
    }

    public function update(Category $category)
    {
        $data = [
            'title' => $category->__get('title'),
            'description' => $category->__get('description')
        ];
        $condition = [
            'categoryID' => $category->__get('categoryID')
        ];
        $this->category->update($data, $condition);
    }

    public function delete($categoryID)
    {
        return $this->category->delete('categoryID', $categoryID);
    }
}
