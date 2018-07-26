<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSpecie;
use App\Specie;
use Auth;

class SpecieController extends Controller
{
    /* -- ESPACE PUBLIC -- */
    public function show() {
        return view('specie.show');
    }

    /* -- ESPACE ADMINISTRATION -- */
    public function list() {
        if (Auth::user()->can('list', Specie::class)) {
            $species = Specie::get();
            return view('admin.specie.list', compact('species'));
        }
        return redirect(route('admin.dashboard'));
    }

    public function edit($id) {
        $specie = Specie::findOrFail($id);
        if (Auth::user()->can('update', $specie)) {
            return view('admin.specie.edit', compact('specie'));
        }
        return redirect(route('admin.specie'));
    }

    public function add() {
        if (Auth::user()->can('create', Specie::class)) {
            return view('admin.specie.add');
        }
        return redirect(route('admin.species'));
    }

    public function update($id, StoreSpecie $request) {
        $specie = Specie::findOrFail($id);
        if (Auth::user()->can('update', $specie)) {
            $specie->name = $request->name;
            $specie->identification = $request->identification;
            $specie->description = $request->description;
            $specie->save();
            return redirect( route('admin.specie.edit', compact('id')) )->withSuccess('Espèce Modifiée');
        }
        return redirect(route('admin.species'));
    }

    public function store(StoreSpecie $request) {
        if (Auth::user()->can('create', Specie::class)) {
            $specie = new Specie;
            $specie->name = $request->name;
            $specie->identification = str_identification( $request->name , '-' );
            $specie->description = $request->description;
            $specie->save();
        }
        return redirect(route('admin.species'));
    }

    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $specie = Specie::findOrFail($id);
        if (Auth::user()->can('delete', $specie)) {
            if( $specie->delete() ){
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function restore() {
        return redirect(route('admin.species'));
    }
}
