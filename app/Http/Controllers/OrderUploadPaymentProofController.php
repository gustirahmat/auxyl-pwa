<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Throwable;

class OrderUploadPaymentProofController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $validated_data = $request->validate([
            'order_id' => 'bail|required|integer',
            'order_payment_proof' => 'required|image|max:2000',
        ]);

        try {
            $order = Order::with('relatedStatuses')->findOrFail($validated_data['order_id']);

            if ($request->has('order_payment_proof')) {
                if (App::environment('production')) {
                    $image_name = $request->file('order_payment_proof')->getRealPath();
                    Cloudder::upload($image_name, null, array(
                        'folder' => 'images/payment-proof/' . $order->order_id,
                        'overwrite' => true,
                        'resource_type' => 'image'
                    ));

                    list($width, $height) = getimagesize($image_name);
                    $category_icon = Cloudder::secureShow(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
                    $path = $category_icon;
                } else {
                    Storage::disk('public')->delete($order->getOriginal('order_payment_proof'));
                    $path = $request->file('order_payment_proof')->store('images/payment-proof/' . $order->order_id, 'public');
                }

                $validated_data['order_payment_proof'] = $path;
            }

            $order->order_payment_proof = $path;
            $order->save();

            $status = new OrderStatus([
                'status_code' => 1,
                'status_action' => 'Mengunggah Bukti Pembayaran',
                'status_comment' => null
            ]);
            $order->relatedStatuses()->save($status);

            return back()->with('message', 'Berhasil mengunggah bukti pembayaran. Admin kami akan segera memverifikasi pesanan Anda. Terima kasih');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }
}
