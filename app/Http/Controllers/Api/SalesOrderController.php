<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SalesOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SalesOrder::with('customer')->get();

        $formatted = $salesOrders->map(function ($saleOrder) {
            return [
                'id' => $saleOrder->id,
                'customer_name' => $saleOrder->customer->name,
                'date' => $saleOrder->date->format('Y-m-d'),
                'total' => $saleOrder->total,
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($validatedData) {
                $productIds = collect($validatedData['items'])->pluck('product_id');
                $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

                $total = 0;
                $syncData = [];

                foreach ($validatedData['items'] as $item) {
                    $product = $products[$item['product_id']];

                    if ($product->stock < $item['qty']) {
                        throw new Exception("Insufficient stock for {$product->name}. Available: {$product->stock}");
                    }

                    $subtotal = $product->price * $item['qty'];
                    $total += $subtotal;

                    $syncData[$product->id] = [
                        'quantity' => $item['qty'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];

                    $product->decrement('stock', $item['qty']);
                }

                $salesOrder = SalesOrder::create([
                    'customer_id' => $validatedData['customer_id'],
                    'date' => $validatedData['date'],
                    'total' => $total,
                ]);

                $salesOrder->products()->sync($syncData);

                return response()->json([
                    'message' => 'Sale created successfully',
                    'sales_order_id' => $salesOrder->id
                ], 201);
            });
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load('customer', 'products');
        return response()->json($salesOrder);
    }
}
