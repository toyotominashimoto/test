<?php

namespace App\Http\Controllers;
use App\Jobs\QueueSenderEmail;
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
            $contacts[] = Contact::where('id', $id)->get();
        }
        foreach ($contacts as $contact) {
            $qs = new QueueSenderEmail(
                $viewModel,
                $request->input('data.message');
                $contact->email;
                $contact;
            );
            $this->dispatch($qs); 
            $record = new Record;
            $record->name = $contact->name;
            $record->email = $contact->email;
            $record->viewname = $viewModel;
            $record->save();
            return response()->json(['msg' => 'mail sent to contacts',
                'contacts' => $contacts]);
        }        
    }
    public function send($message) {
        $qs = new QueueSenderEmail($message);
        $this->dispatch($qs);        
        return redirect()
                ->back()
                ->with('mess', "Сообщение $message отправлено");
    }
}
