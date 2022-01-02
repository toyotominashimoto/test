<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Record;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailsController extends Controller
{
    public function send(Request $request)
    {
        $ids = $request->input("user.ids");
        $view = $request->input('view');
        $viewModel = View::where('name', $view)->get();
        if ($viewModel == null) {
            return response()->json(['answer' => 'View ' . $view . ' not found']);
        }
        $contacts = [];
        foreach ($ids as $id) {
            $contacts[] = Contact::where('id', $id);
        }
        foreach ($contacts as $contact) {
            Mail::send("emailviews." . $viewModel, $contact->toArray(),
                function ($message) {
                    $message->to($contact->email)
                        ->subject($viewModel . " from " . env('APP_NAME'));
                });
            $record = new Record;
            $record->name = $contact->name;
            $record->email = $contact->email;
            $record->viewname = $viewModel;
            $record->save();
        }
    }
}
