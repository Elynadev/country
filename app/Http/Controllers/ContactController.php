<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\ContactMessage;
use App\Models\User;

class ContactController extends Controller
{
    public function index()
    {
        return response()->json(Contact::all());
    }

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'company' => 'required',
                'country' => 'required',
                'country_flag' => 'nullable|url', // Rendre le champ facultatif et s'assurer que c'est une URL valide si fournie
            ]);
        
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'country' => $request->country,
                'country_flag' => $request->country_flag,
            ]);
        
            return response()->json(['message' => 'Contact added successfully']);
        }
        


        // public function store(Request $request)
        // {
            
        //     $request->validate([
        //         'name' => 'required',
        //         'email' => 'required|email',
        //         'phone' => 'required',
        //         'company' => 'required',
        //         'country' => 'required',
        //         'country_flag' => 'nullable|url',
        //     ]);
    
        //     Contact::create($request->all());
    
        //     return redirect()->route('contact.index')->with('success', 'Contact added successfully');
        // }


    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return response()->json(['message' => 'Contact deleted successfully']);
    }
}
