<?php

namespace App\Http\Controllers;

use App\Http\Requests\categories\StoreCategoryRequest;
use App\Http\Requests\categories\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();
        $categories = Category::filter($filters)->paginate(5);

        if ($request->wantsJson() || $request->query('api') == 'true') {
            return response()->json(['data' => $categories], 200);
        } else {
            return view('pages.categories.index', compact('categories'));
        }
    }


    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $defaultValues = [
            'name' => '',
         
        ];

        $validatedData = array_merge($defaultValues, $validatedData);

        $category = Category::create([
            'name' => $validatedData['name'],
            
        ]);

        if ($category) {
            return response()->json(['success' => true, 'message' => 'category created successfully.'], 201);
        }

        return response()->json(['success' => false, 'message' => 'category creation failed.'], 500);
    }


    public function editCategory($id)
    {
        $editCategory = Category::findOrFail($id);
        return response()->json(['editCategory' => $editCategory]);
    }
    public function update(UpdateCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $id = $request->input('id');
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $validatedData['name'],
           
        ]);

        return response()->json(['success' => true, 'message' => 'Category updated successfully.'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully and moved to trash',
        ]);
    }

}
