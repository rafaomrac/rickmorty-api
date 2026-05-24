<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://rickandmortyapi.com/api/character', $request->only([
            'page', 'name', 'status', 'species', 'type', 'gender'
        ]));

        if ($response->failed()) {
            return response()->json(['error' => 'Falha ao buscar personagens'], 502);
        }

        return response()->json($response->json());
    }
}