<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Notifications\ContactCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Events\ContactCreatedEvent;
use App\Events\ContactUpdatedEvent;
use App\Events\ContactDeletedEvent;


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

            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'country' => $request->country,
                'country_flag' => $request->country_flag,
            ]);

             // Envoyer la notification à l'utilisateur actuellement authentifié
        Auth::user()->notify(new ContactCreated($contact));

         // Déclencher l'événement
         event(new ContactCreatedEvent($contact));

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


        public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'company' => 'required',
                'country' => 'required',
                'country_flag' => 'nullable|url', // Rendre le champ facultatif et s'assurer que c'est une URL valide si fournie
            ]);

            $contact = Contact::findOrFail($id);
            $contact->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'country' => $request->country,
                'country_flag' => $request->country_flag,
            ]);

            // Déclencher l'événement
            event(new ContactUpdatedEvent($contact));

            return response()->json(['message' => 'Contact updated successfully']);
        }

        public function destroy($id)
        {
            $contact = Contact::findOrFail($id);
            $contact->delete();

            // Déclencher l'événement
            event(new ContactDeletedEvent($contact));

            return response()->json(['message' => 'Contact deleted successfully']);
        }
}
