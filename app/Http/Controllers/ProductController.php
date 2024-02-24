<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function index($userid)
    {
        $user = User::findOrFail($userid);
        if ($user->user_type == 'admin') {
            $products = Product::with('categories', 'images')->latest()->get();
        } else {
            $products = Product::where('user_id', $user->id)->with('categories', 'images')->latest()->get();
        }
        return response()->json(['products' => $products]);
    }

    public function getAllProducts()
    {
        $products = Product::with('categories', 'images')->latest()->get();
        return response()->json(['products' => $products]);
    }

    public function getAllPaidProducts()
    {
        $paidproducts = Product::where('paid', 'yes')->with('categories', 'images')->latest()->get();
        return response()->json(['paidproducts' => $paidproducts]);
    }

    public function getAllUnpaidProducts()
    {
        $unpaidproducts = Product::where('paid', 'no')->with('categories', 'images')->latest()->get();
        return response()->json(['unpaidproducts' => $unpaidproducts]);
    }

    public function getAllProduct($id)
    {
        $product = Product::where('id', $id)->with('categories', 'images', 'user')->first();
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('categories.id', $product->categories->pluck('id'));
        })->with('categories', 'images', 'user')->get();

        return response()->json([
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'status' => 200
        ], 200);
    }

    public function getFilteredProducts(Request $request, $categoryId)
    {
        $productId = $request->input('productId');
        $sortedProducts = null;
        if ($productId) {
            $products = Product::whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.slug', $categoryId);
            })->with('images')->get();

            $sortedProducts = $products->sortByDesc(function ($product) use ($productId) {
                return $product->slug == $productId ? 1 : 0;
            });
        } else if ($categoryId) {
            $sortedProducts = Product::whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.slug', $categoryId);
            })->with('images')->get();
        } else {
            $sortedProducts = Product::with('categories', 'images')->get();
        }

        return response(['sortedProducts' => $sortedProducts, 'status' => 200], 200);
    }

    public function fetchAllProducts()
    {
        $sortedProducts = Product::with('categories', 'images')->get();
        return response(['sortedProducts' => $sortedProducts, 'status' => 200], 200);
    }

    public function filterProducts(Request $request)
    {
        $categoryIds = $request->input('category_id');
        $minPrice = $request->input('minimum_price');
        $maxPrice = $request->input('maximum_price');

        $productsQuery = Product::query()->with('images');

        if (!empty($categoryIds)) {
            $productsQuery->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        if (!empty($minPrice)) {
            $productsQuery->where('price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        $products = $productsQuery->get();
        $sortedProducts = $products->sortByDesc(function ($product) {
            return $product->id == request('productId') ? 1 : 0;
        });

        return response(['sortedProducts' => $sortedProducts, 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'smallDescription' => 'required|string',
            'description' => 'required|string',
            'images.*' => 'image|max:10000',
        ]);

        $authuser = User::findOrFail($request->user_id);

        $product = new Product([
            'user_id' => $authuser->id,
            'slug' => \Str::uuid(),
            'code' => \Str::uuid(),
            'title' => $validatedData['title'],
            'price' => $validatedData['price'],
            'discount' => $validatedData['discount'],
            'smallDescription' => $validatedData['smallDescription'],
            'description' => $validatedData['description'],
            'facebooklink' => $request->facebooklink,
            'instagramlink' => $request->instagramlink,
            'twitterlink' => $request->twitterlink,
            'youtubelink' => $request->youtubelink,
        ]);

        $product->save();

        $categoryIds = explode(',', $validatedData['category_id']);
        $product->categories()->attach($categoryIds);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $path = $image->store('product_images', 'public');

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image_path = $path;
                $productImage->save();
            }
        }

        return response()->json(['message' => 'Product created successfully'], 200);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'product_images.*' => 'image|max:20480',
        ]);

        $product = Product::findOrFail($id);

        $product->title = $request->title;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->smallDescription = $request->smallDescription;
        $product->description = $request->description;
        $product->facebooklink = $request->facebooklink;
        $product->instagramlink = $request->instagramlink;
        $product->twitterlink = $request->twitterlink;
        $product->youtubelink = $request->youtubelink;

        $categoryIds = explode(',', $request->category_id);
        $product->categories()->sync($categoryIds);

        if ($request->hasFile('product_images')) {
            $imagePaths = [];

            foreach ($request->file('product_images') as $index => $productImage) {
                $imagePath = $this->processAndSaveImage($productImage);
                $imagePaths[] = $imagePath;
            }

            $productImages = [];
            foreach ($imagePaths as $imagePath) {
                $newProductImage = new ProductImage();
                $newProductImage->product_id = $product->id;
                $newProductImage->image_path = $imagePath;
                $newProductImage->save();
                $productImages[] = $newProductImage;
            }

            $product->images()->saveMany($productImages);
        }

        $product->save();

        return response()->json(['product' => $product, 'message' => 'Product updated successfully'], 200);
    }

    private function processAndSaveImage($image)
    {
        $imageName = \Str::uuid() . '.' . $image->getClientOriginalExtension();
        $imageName = $image->store('product_images', 'public');
        return $imageName;
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $imagePaths = $product->images->pluck('image_path')->toArray();
        foreach ($imagePaths as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
        $product->images()->delete();
        $product->categories()->detach();
        $product->delete();



        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    public function deleteServiceImage($id)
    {
        $productimage = ProductImage::where('id', $id)->first();
        $productImage = ProductImage::findOrFail($id);
        $productImage->delete();
        $productimages = ProductImage::where('product_id', $productimage->product_id)->get();
        return response(['productimages' => $productimages, 'status' => 200], 200);
    }
}
