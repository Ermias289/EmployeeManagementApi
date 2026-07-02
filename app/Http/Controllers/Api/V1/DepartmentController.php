<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DepartmentResource::collection(Department::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $validated = $request->validated();

        return DepartmentResource::make(Department::create($validated));    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::findOrFail($id);

        return DepartmentResource::make($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department -> update($request->validated());

        return new DepartmentResource($department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);

        $department -> delete();

        return response()->noContent();
    }

     public function __construct()
    {
        $this->middleware('permission:department.view')->only('index');
        $this->middleware('permission:department.create')->only('store');
        $this->middleware('permission:department.update')->only('update');
        $this->middleware('permission:department.delete')->only('destroy');
    }
}
