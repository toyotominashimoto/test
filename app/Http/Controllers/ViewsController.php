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
        $json = $request->json();
        $view = new View;
        $view->name = $json['name'];
        $view->user_id = $user->id;
        $view->save();
        Storage::put('emailviews/' . $json['name'], $json['content']);
    }
    public function update(Request $request)
    {
        $json = $request->json();
        $oldView = View::find($json['id']);
        $view = View::find($json['id']);
        $view->name = $json['name'] ? $json['name'] : $oldView->name;
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
            $viewsList[] = Storage::get('emailviews/' . $view->name);
        }
        return response()->json($viewsList);
    }
}
