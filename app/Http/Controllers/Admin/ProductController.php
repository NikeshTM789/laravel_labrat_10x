<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, Category};
use DataTables;

class ProductController extends Controller
{
    private Array $rules, $messages;

    public function __construct(){
        $this->rules = [
            "name" => 'required',
            "quantity" => 'gt:0',
            "price" => 'required',
            "discount" => 'nullable|numeric|lt:price',
            "category" => 'required|Array|exclude',
            "details" => 'nullable',
            "featured" => 'nullable'
        ];
        $this->messages = [
            'category.required' => 'Atleast one category must be selected'
        ];
    }

    private function view($blade_file, $compact = [])
    {
        return view('admin.pages.capital.product.' . $blade_file, $compact);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="'. route('admin.product.show', $row->id) .'">Show</a>
                                  <a class="dropdown-item" href="' . route('admin.product.media', ['product' => $row->uuid]) . '">Media</a>
                                  <a class="dropdown-item" href="' . route('admin.product.edit', $row->id) . '">Edit</a>
                                  <form action='.route('admin.product.destroy', $row->id).' method="POST">'
                                  .csrf_field().
                                '<input type="hidden" name="_method" value="DELETE"/>
                                <button class="dropdown-item dt-delete" type="button">Delete</button>
                        </form>
                                </div>
                              </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return $this->view('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = $request->validate($this->rules, $this->messages);
        Product::create($formData)->categories()->attach($request->category);
        return to_route('admin.product.index')->with('success', 'Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('media');
        return $this->view('show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('categories');
        return $this->view('edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $formData = $request->validate($this->rules, $this->messages);
        $formData = array_merge($formData, ['featured' => request('featured', 0)]);
        tap($product)->update($formData)->categories()->sync($request->category);
        return to_route('admin.product.index')->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with(['success' => 'Trashed']);
    }

    public function trash(Request $request, Product $product = null)
    {
        if ($request->isMethod('POST') && $product) {
            $product->restore();
            return back()->with(['success' => 'Restored']);
        }
        if ($request->ajax()) {
            $data = Product::onlyTrashed();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <form action="' . route('admin.product.trash', $row->id) . '" method="POST">' .
                                      csrf_field() .
                                        '<button class="dropdown-item dt-restore" type="button">Restore</button>
                                    </form>
                                </div>
                              </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return $this->view('trash');
    }

    public function media(Request $request, Product $product, $type = null){
        if ($request->isMethod('POST')) {
            if ($type == Product::MEDIA['featured']) {
                $product->addMedia($request->file)->toMediaCollection(Product::MEDIA['featured']);
            }elseif ($type == Product::MEDIA['gallery']) {
                $product->addMedia($request->file[0])->toMediaCollection(Product::MEDIA['gallery']);
            }
            return 'OK';
        }elseif ($request->isMethod('DELETE')) {
            $product->media()->find($request->id)->delete();
            return response()->json('media removed', 200);
        }
        $gallery = $product->getMedia(Product::MEDIA['gallery'])
                    ->map(fn($media) => [
                        'id' => $media->id,
                        'name' => $media->name,
                        'size' => $media->size,
                        'url' => $media->getUrl('thumbnail')
                    ])->toArray();
        $featured = $product->getMedia(Product::MEDIA['featured'])
                        ->map(fn($media) => [
                            'id' => $media->id,
                            'name' => $media->name,
                            'size' => $media->size,
                            'url' => $media->getUrl('thumbnail')
                        ])->toArray();
        return $this->view('media', compact('product','gallery','featured'));
    }
}
