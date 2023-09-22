<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Requests\Admin\ElectionStoreRequest;
use App\Models\Election;
use App\Services\ElectionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ElectionController extends Controller
{
    public function index(Request $request){
        $election = Election::findOrFail($request->route()->parameter('id'))->load(['candidates.voters', 'voters', 'generations.voters']);
        return Inertia::render('Admin/Election/Dashboard', compact('election'));
    }

    public function switch(Request $request){
//        dd($request->route()->parameter('id'));
//        Inertia::share('admin.election.selected', fn (Request $request) => Election::find($request->route()->parameter('id')));
//        Inertia::render('Admin/Election/Dashboard');
        return to_route('admin.vote-system', $request->route()->parameter('id'));
    }

    public function create(Request $request){
        return Inertia::render('Admin/Election/Create');
    }

    public function store(ElectionStoreRequest $request){
        try {
            $election = ElectionService::create($request->all());
            return to_route('admin.vote-system', $election->id)->with('success', 'success to create new election');
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
    }

    public function edit(Request $request){
        $link = Election::with('resultLink')->find($request->route()->parameter('id'));
        return Inertia::render('Admin/Election/Setting', [
            'resultLink' => $link->resultLink->link
        ]);
    }

    public function update(ElectionStoreRequest $request){
        try {
            Election::findOrFail($request->route()->parameter('id'))->update($request->all());
            return back();
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
    }

    public function destroy(Request $request){
        try{
            if (Election::count() <= 1){
                //todo : when delete the only election, send notification cannot delete
                return to_route('admin.vote-System.edit')->with('failed', 'This is the only election existence. You cannot delete it');
            }else{
                $election = Election::find($request->route()->parameter('id'));
                $election->delete();
                return to_route('admin.vote-system.random')->with('success', 'Delete Section Success');
            }
        }catch (\Exception $exception){
            abort(500, $exception->getMessage());
        }
    }
}
