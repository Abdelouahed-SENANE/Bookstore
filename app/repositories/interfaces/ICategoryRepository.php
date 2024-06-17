<?php

interface ICategoryRepository {
    public function findCategoryById($id);
    public function getAllCategories();
    public function store(Category $category);
    public function update(Category $category);
    public function delete($categoryID);
}
