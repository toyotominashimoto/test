<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function create(Request $request)
    {
        $json = $request->json();
        $contact = new Contact;
        $contact->name = $json['name'];
        $contact->email = $json['email'];
        $contact->surname = $json['surname'];
        $contact->work = $json['work'] ? $json['work'] : null;
        $contact->address = $json['address'] ? $json['address'] : null;
        $contact->save();
    }
    public function update(Request $request)
    {
        $json = $request->json();
        $oldContact = Contact::find($json->id);
        $contact = Contact::find($json->id);
        $contact->name = $json['name'] ? $json['name'] : $oldContact->name;
        $contact->email = $json['email'] ? $json['email'] : $oldContact->work;
        $contact->work = $json['work'] ? $json['work'] : $oldContact->work;
        $contact->address = $json['address'] ? $json['address'] : $oldContact->address;
        $contact->surname = $json['surname'] ? $json['surname'] : $oldContact->surname;
        $contact->save();
    }
    public function show(Request $request)
    {
        $contacts = Contact::all();
        return response()->json($contacts);
    }
}
