<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserCreateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    private function view($blade_file, $compact = [])
    {
        return view('admin.pages.user.' . $blade_file, $compact);
    }

    private function indexQuery(Request $request, Bool $onlyTrashed = false): Array
    {
        $columns = $searchable = [];
        foreach ($request->columns as $item) {
            array_push($columns, $item['name']);
            if ($item['searchable'] == 'true') {
                array_push($searchable, $item['name']);
            }
        }
        $column     = request()->order[0]['column'] ? $columns[request()->order[0]['column']] : $columns[0];
        $order      = request()->order[0]['dir'];
        $limit_init = request('start');
        $to         = request('length');
        $src        = User::when($onlyTrashed, fn($qry) => $qry->onlyTrashed())
            ->select(['*', 'users.id as id'])
            ->where(function ($qry) use ($request, $searchable) {
                foreach ($searchable as $item) {
                    $qry->orWhere($item, 'LIKE', '%' . $request->search['value'] . '%');
                }
            })
            ->orderBy($column, $order);

            $recordsTotal = $recordsFiltered = $src->count();
            $data = $src->when($to > 1, fn($qry) => $qry->skip($limit_init)->take($to))->get();
        return compact('recordsTotal', 'recordsFiltered', 'data');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->indexQuery($request);
            return response()->json($data);
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
    public function store(UserFormRequest $request)
    {
        $password = Str::random(8);
        $request->merge(['role' => User::ADMIN, 'password' => $password]);
        $user_infos = $request->only(['name', 'email', 'role', 'password']);
        event(new UserCreateEvent(...$user_infos));
        return back()->withSuccess('An email verification link has been sent');
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
    public function edit(User $user)
    {
        return $this->view('edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, User $user)
    {
        $user->update($request->validated());
        return to_route('admin.user.index')->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->withSuccess('Deleted');
    }

    public function trash(Request $request, User $user = null)
    {
        if ($request->isMethod('POST') && $user) {
            $user->restore();
            return back()->with(['success' => 'Restored']);
        }
        if ($request->ajax()) {
            $data = $this->indexQuery($request, true);
            return response()->json($data);
        }
        return $this->view('trash');
    }
}
