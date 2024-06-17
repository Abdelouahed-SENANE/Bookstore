<?php 
    interface ICartItemRepository {
        public function addToCart($cartID , $bookID , $quantity);
        public function deleteFromCart($cartID , $bookID);
        public function showBooksInCart($cartID);
    }