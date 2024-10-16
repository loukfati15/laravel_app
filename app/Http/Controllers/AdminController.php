<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Models\Superuser;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon;
use App\Models\Payment;

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

     public function manageUsers(Request $request)
{
    $query = User::query();

    // Search/Filter functionality
    if ($request->filled('enable')) {
        $query->where('enable', $request->input('enable'));
    }

    if ($request->filled('user_type')) {
        $query->where('user_type', $request->input('user_type'));
    }

    if ($request->filled('main_user')) {
        $query->where('main_user', $request->input('main_user'));
    }

    $users = $query->paginate(10); // Adjust pagination as needed

    // Fetch users with user_type 1 for the dropdown
    $mainUsers = User::where('user_type', 1)->get();

    return view('admin.users.manage', compact('users', 'mainUsers'));
}

// Update the main_user field
public function updateMainUser(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->main_user = $request->input('main_user');
    $user->save();

    return redirect()->route('admin.users.manage')->with('status', 'Main User updated successfully.');
}

     
// Update the enable field
public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->enable = $request->input('enable');
    $user->save();

    return redirect()->route('admin.users.manage')->with('status', 'User updated successfully.');
}

public function managePayments(Request $request)
    {
        $oneYearAgo = Carbon::now()->subYear();

        // Get payments where invoice_date is within the last year
        $payments = Payment::where('invoice_date', '>=', $oneYearAgo)->get();

        return view('admin.payments.manage', compact('payments'));
    }

    // Method to update pay_state and commentaire
    public function updatePayment(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->pay_state = $request->input('pay_state');
        $payment->commentaire = $request->input('commentaire');
        $payment->save();

        return redirect()->route('admin.payments.manage')->with('status', 'Payment updated successfully.');
    }

}


