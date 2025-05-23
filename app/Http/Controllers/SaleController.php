<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $query = Sale::with(['customer', 'items.product']);


            // Filter by customer name
            if ($request->filled('customer_name')) {
                $query->whereHas('customer', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->customer_name . '%');
                });
            }

            // Filter by product name
            if ($request->filled('product_name')) {
                $query->whereHas('items.product', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->product_name . '%');
                });
            }

            // Filter by date range
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $query->whereBetween('date', [$request->date_from, $request->date_to]);
            } elseif ($request->filled('date_from')) {
                $query->where('date', '>=', $request->date_from);
            } elseif ($request->filled('date_to')) {
                $query->where('date', '<=', $request->date_to);
            }

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('customer_name', fn($sale) => $sale->customer->name ?? 'N/A')
            ->addColumn('total', fn($sale) => number_format($sale->total, 2))
            ->addColumn('action', function ($sale) {
                $viewBtn = '<button class="btn btn-info btn-sm btn-view" data-id="' . $sale->id . '"><i class="fas fa-eye"></i></button> ';
                $trashBtn = '<button class="btn btn-danger btn-sm btn-trash" data-id="' . $sale->id . '"><i class="fas fa-trash"></i></button>';

                return $viewBtn . $trashBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }


        return view('sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::where('name', '!=', 'admin')->latest()->get();
        $products = Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
            'price' => 'required|array|min:1',
            'price.*' => 'required|numeric|min:0',
            'discount' => 'nullable|array',
            'discount.*' => 'nullable|numeric|min:0|max:100',
        ])->validate();

        DB::beginTransaction();

        try {
            $grandTotal = 0;
            $products = [];

            foreach ($request->product_id as $index => $productId) {
                $qty = $request->quantity[$index];
                $price = $request->price[$index];
                $discount = $request->discount[$index] ?? 0;

                $subtotal = $qty * $price;
                $subtotal -= ($subtotal * ($discount / 100));
                $grandTotal += $subtotal;

                $products[] = [
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                    'discount' => $discount,
                ];
            }

            $sale = Sale::create([
                'user_id' => $request->customer_id,
                'date' => $request->date,
                'total' => $grandTotal,
            ]);

            foreach ($products as $product) {
                $sale->items()->create($product);
            }

            DB::commit();
            return response()->json(['message' => 'Sale created successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create sale: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = Sale::with(['customer', 'items.product'])->findOrFail($id);

        return response()->json([
            'customer' => $sale->customer,
            'total' => $sale->total,
            'created_at' => $sale->created_at,
            'items' => $sale->items,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function trash(Sale $sale)
    {
        $sale->delete();
        return response()->json(['success' => 'Sale moved to trash']);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            
            $query = Sale::onlyTrashed()->with(['customer', 'items.product']);


            // Filter by customer name
            if ($request->filled('customer_name')) {
                $query->whereHas('customer', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->customer_name . '%');
                });
            }

            // Filter by product name
            if ($request->filled('product_name')) {
                $query->whereHas('items.product', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->product_name . '%');
                });
            }

            // Filter by date range
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $query->whereBetween('date', [$request->date_from, $request->date_to]);
            } elseif ($request->filled('date_from')) {
                $query->where('date', '>=', $request->date_from);
            } elseif ($request->filled('date_to')) {
                $query->where('date', '<=', $request->date_to);
            }

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('customer_name', fn($sale) => $sale->customer->name ?? 'N/A')
            ->addColumn('total', fn($sale) => number_format($sale->total, 2))
            ->addColumn('action', function ($sale) {
                $restoreBtn = '<button class="btn btn-success btn-sm btn-restore" data-id="' . $sale->id . '"><i class="fas fa-trash-restore"></i></button>';
                $deleteBtn = '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $sale->id . '"><i class="fas fa-trash-alt"></i></button>';
                return $restoreBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }


        return view('sales.trashed');
    }

    public function restore($id)
    {
        $sale = Sale::withTrashed()->findOrFail($id);
        $sale->restore();
        return response()->json(['success' => 'Sale restored successfully']);
    }

    public function forceDelete($id)
    {
        $sale = Sale::withTrashed()->findOrFail($id);
        $sale->forceDelete();
        return response()->json(['success' => 'Sale permanently deleted']);
    }

}
