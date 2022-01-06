<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ViewsController extends Controller
{
    public function create(Request $request)
    {        
        $user = auth()->user();
        $validated = $request->validate([
            "view" => "required|string",
            "content" => "required|string"
        ]);
        $json = $request->json();
        $view = new View;
        $view->name = $json['name'];
        $view->user_id = $user->id;
        $view->message_text = $json['content'];
        $view->save();
        Storage::put('emailviews/' . $json['name'], $json['content']);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "content" => "required|string"
        ]);
        $json = $request->json();
        $oldView = View::find($json['id']);
        $view = View::find($json['id']);
        $view->name = $json['name'] ? $json['name'] : $oldView->name;
        $view->message_text = $json['content'] ? $json['content'] : $oldView->message_text;
        Storage::put('emailviews/' . $json['name'], $json['content']);
        $view->save();
    }
    public function show(Request $request)
    {
        $json = $request->json();
        $user = auth()->user();
        $views = View::where('user_id', $user->id);
        $viewsList = [];
        foreach ($views as $view) {
            $viewsList[] = [
                $view->id,
                Storage::get('emailviews/' . $view->name),
                $view->message_text,
            ];
        }
        return response()->json($viewsList);
    }
}
