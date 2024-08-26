<?php

namespace App\Http\Controllers;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Models\Superuser;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash; 

class AdminController extends Controller
{
    public function index()
    {
        $superusers = Superuser::where('approved', false)->get();
        return view('admin.dashboard', compact('superusers'));
    }

    public function approve($id)
    {
        $superuser = Superuser::findOrFail($id);
        $superuser->approved = true;
        $superuser->date = now();
        $superuser->save();

        return redirect()->route('admin.dashboard')->with('status', 'Superuser approved successfully.');
    }

    //methode to delete superuser acounte
    public function destroy($id)
    {
        $superuser = Superuser::findOrFail($id);
        $superuser->delete();

        return redirect()->route('admin.dashboard')->with('status', 'Superuser deleted successfully.');
    }
    // Méthode pour afficher le formulaire d'édition des régions
    public function editRegions($id)
    {
        $superuser = Superuser::findOrFail($id);
        $allRegions = Region::all(); // Toutes les régions disponibles

        return view('admin.edit-regions', compact('superuser', 'allRegions'));
    }

    // Méthode pour mettre à jour les régions (déjà existante)
    public function updateRegions(Request $request, $id)
    {
        $superuser = Superuser::findOrFail($id);

        $request->validate([
            'region_ids' => 'required|array',
            'region_ids.*' => 'exists:regions,id',
        ]);

        $superuser->regions()->sync($request->region_ids);

        return redirect()->route('admin.dashboard')->with('status', 'Regions updated successfully for the superuser.');
    }
      // Method to show the form to create a new admin
    public function createAdmin()
    {
        return view('admin.create-admin');
    }
     // Method to store a new admin in the database
     public function storeAdmin(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:admins',
             'password' => 'required|string|min:8|confirmed',
         ]);
 
         Admin::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
         ]);
 
         return redirect()->route('admin.dashboard')->with('status', 'Admin created successfully.');
     }
}


