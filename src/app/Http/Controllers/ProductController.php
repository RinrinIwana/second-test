<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Season;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc'); // デフォルトは新着順
        }
        $products = $query->with('seasons')->paginate(6);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $seasons = [
            (object)['id' => 1, 'name' => '春'],
            (object)['id' => 2, 'name' => '夏'],
            (object)['id' => 3, 'name' => '秋'],
            (object)['id' => 4, 'name' => '冬'],
        ];

        return view('products.create', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
        ]);

        $product->seasons()->attach($validated['seasons']);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    public function edit(Product $product)
    {
        $seasons = Season::all();
        $productSeasons = $product->seasons->pluck('id')->toArray();

        return view('products.edit', compact('product', 'seasons', 'productSeasons'));
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0|max:10000',
            'season_ids' => 'required|array',
            'description' => 'required|max:120',
            'image' => 'nullable|image|mimes:jpeg,png',
        ], [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'season_ids.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.image' => '画像ファイルを指定してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ]);

        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();
        $product->seasons()->sync($validated['season_ids']);

        return redirect()->route('products.index');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
    public function show(Product $product)
    {
        $product->load('seasons');
        return view('products.show', compact('product'));
    }
}