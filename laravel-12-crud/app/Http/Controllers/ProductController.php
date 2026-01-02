<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\product;
use App\Models\category;

class ProductController extends Controller
{
    public function index(Request $request){
        $query = product::query();
        if(request()->has("search") && $request->search){
            $query = $query->where("name", "like", "%".$request->search."%")
                            ->orWhere("description", "like", "%".$request->search."%");
        }
        $products = $query->latest()->paginate(5);
        return view("product.product-list", compact("products"));
    }

    public function create(){
        $categories = category::all();
        return view("product.create", compact("categories"));
    }

    public function store(Request $request){
        $validated = $request->validate([
            "name"=> "required|string",
            "description"=> "nullable|string",
            "price"=> "required|numeric",
            "quantite"=> "required|numeric",
            "status"=> "required",
            "category_id"=> "required",
            "image"=> "nullable|image|mimes:jpg,png",
        ]);
        if ($request->hasFile("image")){
            $validated["image"] = $request->file("image")->store("product", "public");
        }
        product::create($validated);

        return redirect()->route("product.index")->with("success", "product added successfully");
    }

    public function show($id){
        $product = Product::find($id);
        return view("product.show", compact("product"));
    }

    public function edit($id){
        $product = Product::find($id);
        $categories = category::all();
        return view("product.edit", compact("product", "categories"));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            "name"=> "required|string",
            "description"=> "nullable|string",
            "price"=> "required|numeric",
            "quantite"=> "required|numeric",
            "status"=> "required",
            "category_id"=> "required",
            "image"=> "nullable|image|mimes:jpg,png",
        ]);
        
        $product = Product::find($id);
        
        if ($request->hasFile("image")){
            if($product->image && Storage::disk("public")->exists($product->image)){
                Storage::disk("public")->delete($product->image);
            }
            $validated["image"] = $request->file("image")->store("product", "public");
        }
        
        Product::find($id)->update($validated);

        return redirect()->route("product.index")->with("success", "Product updated successfully");
    }

    public function destroy($id){
        $product = Product::find($id);
        if($product->image && Storage::disk("public")->exists($product->image)){
            Storage::disk("public")->delete($product->image);
        }
        $product->delete();
        return redirect()->route("product.index")->with("success", "Product deleted successfully");
    }

    public function trashedProduct(Request $request){
        $query = product::query();
        if(request()->has("search") && $request->search){
            $query = $query->where("name", "like", "%".$request->search."%")
                            ->orWhere("description", "like", "%".$request->search."%");
        }
        $products = $query->onlyTrashed()->paginate(5);
        return view("product.deleted-product", compact("products"));
    }


    public function destroyProduct($id){
        $product = Product::withTrashed()->find($id);
        if($product){
            if($product->image && Storage::disk("public")->exists($product->image)){
                Storage::disk("public")->delete($product->image);
            }
            $product->forceDelete();
            return redirect()->route("product.trashed")->with("success", "Product permanently deleted successfully");
        }
        return redirect()->route("product.trashed")->with("error", "Product not found");
    }

    public function restoreProduct($id){
        $product = Product::withTrashed()->find($id);
        if($product){
            $product->restore();
            return redirect()->route("product.trashed")->with("success", "Product restored successfully");
        }
        return redirect()->route("product.trashed")->with("error", "Product not found");
    }


}
