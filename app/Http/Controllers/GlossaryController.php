<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Glossary;

class GlossaryController extends Controller
{
    public function showDefinition($word) {
        $word = Glossary::where('definition', $word)->first();
        $data = [
            'definition' => $word->definition,
            'description' => $word->description
        ];
        return view('definition-glossary', compact('data'));
    }
}
