<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGenRequest;
use App\Models\Generation;
use Illuminate\Http\Request;

class GenerationController extends Controller
{
    public function store(StoreGenRequest $request){
        try {
            $request->merge([
                'election_id' => $request->route()->parameter('id')
            ]);
            Generation::create($request->all());
            return to_route('admin.vote-System.edit', $request->route()->parameter('id'));
        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function destroy(Request $request, $id){
        try {
            $gen = Generation::find($request->genId);
            $gen->delete();
            return to_route('admin.vote-System.edit', $id);
        }catch (\Exception $exception){
            return $exception;
        }
    }
}
