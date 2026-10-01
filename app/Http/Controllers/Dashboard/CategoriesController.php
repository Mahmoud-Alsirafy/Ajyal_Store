<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Rules\Filter;
use App\Traits\UploadLogoImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    use UploadLogoImage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('category.view')) {
            abort(403);
        }
        $request = request();


        $Categories = Categorie::with('parent')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id ) as products_count')
            // ->select('categories.*')
            // ->withCount('Products')
            ->withCount([
                'Products as product_number' => function ($query) {
                    $query->where('status', '=', 'active');
                }
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();
        return view('dashboard.categories.index', compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('category.create')) {
            abort(403);
        }
        $Parents = Categorie::all();
        return view('Dashboard.Categories.create', compact('Parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('category.create');
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name', new Filter(['laravel', 'php', 'admin'])],
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'required|string',
            'logo_image' => 'image|max:2048',
            'cover_images' => 'array',
            'cover_images.*' => 'image|max:2048',
            'status' => 'in:active,inactive',
        ]);
        $data = $request->except('logo_image', 'cover_images');

        DB::beginTransaction();
        try {
            $data['logo_image'] = $this->uploadeLogoImage($request);
            $data['cover_images'] = $this->uploadeImages($request);

            Categorie::create($data);
            DB::commit();
            return Redirect::route('Categories.index')
                ->with('success', 'Category Created');
        } catch (\Throwable $e) {
            DB::rollback();
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $category)
    {
        if (Gate::denies('category.view')) {
            abort(403);
        }
        // return $category;

        return view('Dashboard.Categories.show', [
            'categorie' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('category.update');
        $categorie = Categorie::findOrFail($id);
        $Parents = Categorie::where('id', '<>', $id)->where(
            function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id);
            }
        )->get();
        return view('Dashboard.Categories.edit', compact('categorie', 'Parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        Gate::authorize('category.update');
        $old_image = $categorie->logo_image;
        $cover_images = $categorie->cover_images;
        $data = $request->except('logo_image', 'cover_images');

        if ($request->hasFile('logo_image')) {
            $data['logo_image'] = $this->uploadeLogoImage($request);
        }

        if ($request->hasFile('cover_images')) {
            $data['cover_images'] = $this->uploadeImages($request);
        }

        DB::beginTransaction();
        try {
            $categorie->update($data);

            if ($old_image && isset($data['logo_image'])) {
                Storage::disk('uploads')->delete($old_image);
            }

            if ($cover_images && isset($data['cover_images'])) {
                foreach (explode(',', $cover_images) as $image) {
                    Storage::disk('uploads')->delete($image);
                }
            }

            DB::commit();
            return Redirect::route('Categories.index')
                ->with('success', 'Category Updated');
        } catch (\Throwable $e) {
            DB::rollback();
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        if (Gate::denies('category.delete')) {
            abort(403);
        }
        DB::beginTransaction();
        try {
            $categorie->delete();
            DB::commit();
            return Redirect::route('Categories.index')
                ->with('danger', 'Category Deleted');
        } catch (\Throwable $e) {
            DB::rollBack();
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    public function trashed()
    {
        $categories = Categorie::onlyTrashed()->paginate();
        return view('Dashboard.Categories.trashed', compact('categories'));
    }
    public function restore($id)
    {
        $categorie = Categorie::onlyTrashed()->findOrFail($id);
        $categorie->restore();
        return Redirect::route('Categories.index')
            ->with('success', 'Category Restored');
    }

    public function forceDelete($id)
    {
        $categorie = Categorie::onlyTrashed()->findOrFail($id);
        $categorie->forceDelete();
        if ($categorie->logo_image) {
            Storage::disk('uploads')->delete($categorie->logo_image);
        }
        if ($categorie->cover_images) {
            foreach (explode(',', $categorie->cover_images) as $image) {
                Storage::disk('uploads')->delete($image);
            }
        }
        return Redirect::route('Categories.index')
            ->with('success', 'Category force deleted');
    }
}