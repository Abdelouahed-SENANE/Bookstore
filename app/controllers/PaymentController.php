<?php
require '../../vendor/autoload.php';

\Stripe\Stripe::setApiKey('your-secret-key-here');

class PaymentController extends Controller
{
    use ApiResponse;
    private $paymentRepository;
    private $orderRepository;
    private $orderLineRepository;
    private $cartRepository;
    private $cartItemRepository;

    public function __construct(PaymentRepository $paymentRepository, OrderRepository $orderRepository, orderLineRepository $orderLineRepository, CartItemRepository $cartItemRepository, CartRepository $cartRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->orderLineRepository = $orderLineRepository;
        $this->orderRepository = $orderRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->cartRepository = $cartRepository;
    }

    public function checkout()
    {
        $authUser = $_SESSION['user']['userID'];
        $cart = $this->cartRepository->findCartOfCustomer($authUser);

        if (empty($cart)) {
            $this->error([], 'Cart not found', 404);
            return;
        }
        $books = $this->cartItemRepository->showBooksInCart($cart->cartID);
        $lineItems = [];
        foreach ($books as $book) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $book['name'],
                        'description' => $book['description']
                    ],
                    'unit_amount' => $book['price'],
                ],
                'quantity' => $book['quantity']
            ];
        }
        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => 'http://localhost:3000/payment-success?session_id={CHECKOUT_SESSION_ID} ',
                'cancel_url' => 'http://localhost:3000/payment-cancel',
            ]);
            $newOrder = new Order();
            $newOrder->__set('userID', $authUser);
            $newOrder->__set('status', 'PENDING');
            $newOrder->__set('orderDate', date('Y-m-d H:i:s'));
            $newOrder->__set('totalPrice', $this->calculateTotalPrice($books));
            $orderID = $this->orderRepository->store($newOrder);

            $newPayment = new Payment();
            $newPayment->__set('orderID', $orderID);
            $newPayment->__set('amount', $this->calculateTotalPrice($books));
            $newPayment->__set('status', 'PENDIND');
            $newPayment->__set($session->id, 'sessionID');
            $this->success([$_SESSION['sessionID'] => $session->id], 'Session Created Succefully ', 200);
        } catch (\Exception $e) {
            $this->error([], 'Error :' . $e->getMessage(), 500);
        }
    }

    public function handlePaymentSuccess()
    {
        $sessionID = $_SESSION['sessionID'];
        if (!isset($sessionID)) {
            $this->error([], 'Sesseion ID is not found', 404);
            return;
        }
        $authUser = $_SESSION['user']['userID'];
        if (isset($authUser)) {
            $this->error([], 'User ID is not found', 404);
            return;
        }
        $cart = $this->cartRepository->findCartOfCustomer($authUser);
        $cartItems = $this->cartItemRepository->showBooksInCart($cart->cartID);
        try {
            $paymentID = $this->paymentRepository->updateStatus($sessionID, "PAID");
            $payment = $this->paymentRepository->getPaymentBySessionID($sessionID);
            if (!isset($payment)) {
                $this->error([], 'Payment is not found', 404);
                return;
            }
            $order = $this->orderRepository->getOneOrderById($payment->orderID);
            $orderID = $this->orderRepository->updateStatusOrder($order->orderID , 'PAID');

            $this->orderLineRepository->store($cartItems , $orderID);

            $this->cartItemRepository->clearCartItem($cart->cartID);
        } catch (Exception $e) {
            $this->error([], 'Error Database' . $e->getMessage(), 500);
            return;
        }
    }


    private function calculateTotalPrice(array $items)
    {
        $amount = 0;
        foreach ($items as $item) {
            $amount += $item['quantity'] * $item['price'];
        }
        return $amount;
    }
}
