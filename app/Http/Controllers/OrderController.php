<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\OrderStatus;
use App\Models\ProductStock;
use App\Notifications\OrderCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Throwable;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Order/Index', [
            'orders' => Auth::user()->relatedCustomer->relatedOrders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'carts' => 'bail|required|array',
            'name' => 'required|string',
            'phone' => 'required|digits_between:8,20',
            'address' => 'required|string',
            'zipcode' => 'required|numeric',
            'kelurahan' => 'required|string',
            'kecamatan' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
        ]);

        try {
            $new_order_no = '00001';
            $orders_no = [];
            $orders = Order::withTrashed()->whereNotNull('order_no')->lockForUpdate()->get();
            foreach ($orders as $order) {
                array_push($orders_no, substr($order->order_no, -5));
            }
            if ($orders_no) {
                sort($orders_no);
                $value = end($orders_no) + 1;
                $new_order_no = str_pad($value, 5, "0", STR_PAD_LEFT);
            }

            DB::beginTransaction();

            $order = Order::with('relatedProducts', 'relatedDelivery', 'relatedStatuses')
                ->create([
                    'customer_id' => Auth::user()->relatedCustomer->customer_id,
                    'order_latest_status' => 1,
                    'order_no' => $new_order_no,
                    'order_date' => today(),
                ]);

            // Simpan produk yang dipesan
            $total = 0;
            $supplier_id = null;
            $carts = Cart::with('relatedProduct')->where('user_id', '=', Auth::id());
            foreach ($carts->get() as $cart) {
                if ($cart->relatedProduct->product_stock - $cart->cart_qty < 0) {
                    return back()->withErrors('Anda tidak dapat melanjutkan pesanan karena pesanan Anda melebihi stok yang kami sediakan.', 404);
                }
                // Kurangi stok
                $cart->relatedProduct->product_stock = $cart->relatedProduct->product_stock - $cart->cart_qty;
                $cart->relatedProduct->save();
                $stock = new ProductStock([
                    'stock_qty' => $cart->cart_qty,
                    'stock_status' => false,
                    'stock_notes' => 'Pesanan baru #' . $order->order_no . ' ' . Auth::user()->name . ' ' . $cart->cart_qty . ' pcs',
                ]);
                $cart->relatedProduct->relatedStocks()->save($stock);

                $product = $order->relatedProducts()->create([
                    'product_id' => $cart['product_id'],
                    'category_id' => $cart['category_id'],
                    'order_product_qty' => $cart['cart_qty'],
                    'order_product_price' => $cart['product_price'],
                    'order_product_subtotal' => $cart['product_price'] * $cart['cart_qty'],
                ]);

                # get total summary
                $total += $product->order_product_subtotal;

                $supplier_id = $cart['supplier_id'];
            }

            // Simpan total pesanan
            $order->update([
                'order_total' => $total,
                'supplier_id' => $supplier_id
            ]);

            // Remove carts
            $carts->delete();

            // Buat pengiriman
            $delivery = new OrderDelivery([
                'delivery_contact_name' => $validated_data['name'],
                'delivery_contact_phone' => $validated_data['phone'],
                'delivery_address' => $validated_data['address'],
                'delivery_zipcode' => $validated_data['zipcode'],
                'delivery_kelurahan' => $validated_data['kelurahan'],
                'delivery_kecamatan' => $validated_data['kecamatan'],
                'delivery_kabkot' => $validated_data['city'],
                'delivery_provinsi' => $validated_data['province'],
                'delivery_max_date' => Carbon::today('Asia/Jakarta')->addDays(30),
            ]);
            $order->relatedDelivery()->save($delivery);

            // Buat status
            $status = new OrderStatus([
                'status_code' => 1,
                'status_action' => 'Menunggu pembayaran',
                'status_comment' => null
            ]);
            $order->relatedStatuses()->save($status);

            // Auth::user()->notify(new OrderCreated($order));

            DB::commit();

            return back()->with('message', 'Pesanan Anda berhasil disimpan.');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Inertia\Response
     */
    public function show(Order $order): \Inertia\Response
    {
        return Inertia::render('Order/Show', [
            'order' => $order->loadMissing('relatedDelivery', 'relatedStatuses', 'relatedComplain')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
