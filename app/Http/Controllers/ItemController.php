<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()->items()->with('category')->get();
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }
    public function store(ItemRequest $request)
    {
        $item = $request->user()->items()->create($request->validated());
        return response()->json($item);
    }
    public function update(ItemRequest $request, Item $item)
    {
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(['message'=>'حذف شد']);
    }
}
