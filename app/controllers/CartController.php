<?php
class CartController extends Controller
{
    use ApiResponse;
    private $cartItemRepository;
    private $cartRepository;

    public function __construct(CartRepository $cart, CartItemRepository $cartItem)
    {
        $this->cartRepository = $cart;
        $this->cartItemRepository = $cartItem;
    }

    public function addToCart()
    {
    // Add Book From Cart items
        if ($_SERVER['METHOD_REQUEST'] === "POST") {
            try {
                if (!isset($_SESSION['user']['userID'])) {
                    $this->error([], 'User not authenticated', 401);
                    return;
                }
                $authUser = $_SESSION['user']['userID'];
                $cart = $this->cartRepository->findCartOfCustomer($authUser);
                if (!$cart && isset($cart->cartID)) {
                    $this->error([], 'Cart not found', 404);
                    return;
                }
    
                if (!isset($_POST['bookID'])) {
                    $this->error([], 'Book not found', 404);
                    return;
                }
                $bookID = $_POST['bookID'];
                $quantity = $_POST['quantity'];
                $this->cartItemRepository->addToCart($cart->cartID , $bookID , $quantity);
                $this->success([] ,  'Book added to cart successfully.');
            } catch (Exception $e) {
                $this->error('Failed to add book to cart: ' . $e->getMessage(), 500);
            }
        }else {
            $this->error([], 'Invalid request method', 405);
        }
    }
    // Delete Book From Cart items
    public function deleteFromCart(){
        if ($_SERVER['METHOD_REQUEST'] === "POST") {
            try {
                if (!isset($_SESSION['user']['userID'])) {
                    $this->error([], 'User not authenticated', 401);
                    return;
                }
                $authUser = $_SESSION['user']['userID'];
                $cart = $this->cartRepository->findCartOfCustomer($authUser);
                if (!$cart && isset($cart->cartID)) {
                    $this->error([], 'Cart not found', 404);
                    return;
                }
    
                if (!isset($_POST['bookID'])) {
                    $this->error([], 'Book not found', 404);
                    return;
                }
                $bookID = $_POST['bookID'];
                $this->cartItemRepository->deleteFromCart($cart->cartID , $bookID);
                $this->success([] ,  'Book Deleted to cart successfully.');
            } catch (Exception $e) {
                $this->error('Failed to add book to cart: ' . $e->getMessage(), 500);
            }
        }else {
            $this->error([], 'Invalid request method', 405);
        }
    }

    public function showBookInCart(){
        if ($_SERVER['METHOD_REQUEST'] === 'GET') {
            try {
                $authUser = $_SESSION['user']['userID'];
                $cart = $this->cartRepository->findCartOfCustomer($authUser);
                if (!$cart || !isset($cart->cartID)) {
                    $this->error([], 'Cart not found', 404);
                    return;
                }
                $data = $this->cartItemRepository->showBooksInCart($cart->cartID);
                $this->success($data , 'get all books inside cart' , 200);
            } catch (Exception $e) {
                $this->error([], 'Error to get All books inside Cart' . $e->getMessage());
            }
        }
    }
}
