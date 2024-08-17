<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private function view($blade_file, $compact = [])
    {
        return view('admin.pages.capital.category.' . $blade_file, $compact);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="' . route('admin.category.edit', $row->id) . '">Edit</a>
                                  <form method="POST" action="'.route('admin.category.destroy', $row->id).'">
                                      '.csrf_field().'
                                      <input type="hidden" name="_method" value="DELETE">
                                      <a class="dropdown-item dt-ajax-delete" href="#">Delete</a>
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categories,name',
            ], [
                'name.required' => 'category name is required',
            ]);

            if ($validator->fails()) {
                // $errorMessages = $validator->errors()->all();
                $errorMessages = $validator->errors()->getMessages();
                $errorMessage  = (reset($errorMessages))[0];

                if (count($errorMessages) > 1) {
                    $errorMessage .= ' (and ' . count($errorMessages) . ' more error)';
                }

                return response(['message' => $errorMessage, 'errors' => $errorMessages], 422);
            }
            Category::create($request->only('name'));
            return response(['message' => 'Category added'], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return $this->view('edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'category name is required',
        ]);

        if ($validator->fails()) {
            // $errorMessages = $validator->errors()->all();
            $errorMessages = $validator->errors()->getMessages();
            $errorMessage  = (reset($errorMessages))[0];

            if (count($errorMessages) > 1) {
                $errorMessage .= ' (and ' . count($errorMessages) . ' more error)';
            }

            return response(['message' => $errorMessage, 'errors' => $errorMessages], 422);
        }

        $category->update($request->only('name'));
        $message = ($category->wasChanged() ? 'Category Updated' : 'Category Remained Same');

        return response(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response(['message' => 'Category Removed']);
    }

    public function trash(Request $request, Category $category = null)
    {
        if ($request->isMethod('POST') && $category) {
            $category->restore();
            return back()->with(['success' => 'Restored']);
        }
        if ($request->ajax()) {
            $data = Category::onlyTrashed();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <form action="' . route('admin.category.trash', $row->id) . '" method="POST">' .
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
}
