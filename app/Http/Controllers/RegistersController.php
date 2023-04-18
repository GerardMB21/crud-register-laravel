<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Registers;

class RegistersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registers = Registers::all();

        return response()->json($registers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Registers::create($request->all());
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
        $register = Registers::find($id);

        $register->update([
            'name' => $request['name'],
            'document' => $request['document'],
            'type_document_id' => $request['type_document_id']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $register = Registers::find($id);

        $register->delete();
    }
}
