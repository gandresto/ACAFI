<?php

namespace App\Http\Controllers;

use App\CategoriasFeedback;
use App\Feedback;
use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function create(Request $request)
    {
        $categorias = CategoriasFeedback::all();
        return view('feedback.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'categoria' => 'required|exists:categoriasfeedback,id',
            'mensaje' => 'required|min:10|max:500',
        ]);

        $feedback = Feedback::create([
            'user_id' => Auth::user()->id,
            'mensaje' => $data['mensaje'],
            'categoria_id' => $data['categoria']
        ]);
        
        Mail::to('gandresto@outlook.com')->send(new FeedbackMail($feedback));

        return back()->with('success', 'Gracias por enviar sus comentarios.');
    }
}
