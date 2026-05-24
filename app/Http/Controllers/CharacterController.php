<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    public function index()
    {
        $response = Http::get('https://rickandmortyapi.com/api/character');

        return response()->json($response->json());
    }
}