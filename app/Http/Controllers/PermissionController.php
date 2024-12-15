<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role_id = $request->role;
        $routes = $request->except('_token', 'role');
        $data = [];

        foreach($routes as $route){
            $row['role_id'] = $role_id;
            $row['route_name'] = $route;
            array_push($data, $row);
        }

        $status = true;
        DB::beginTransaction();
        try{
            Permission::where('role_id', $role_id)->delete();
            $result = Permission::insert($data);

            if(!$result){
                DB::rollback();
                $status = false;
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $status = false;
        }

        if($status){
            session(['success' => 'Permission was saved successfully']);
        }else {
            session(['error' => 'Permission can not save']);
        }

        return view('roles.index', ['role_id' => $role_id]);
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
}
