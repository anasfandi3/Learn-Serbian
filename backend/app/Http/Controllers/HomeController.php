<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TranslationResource;
use App\Models\Translation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getTranslations()
    {
        return response()->json(['data' => TranslationResource::collection(Translation::inRandomOrder()->get())]);
    }

    public function checkAnswer(Request $request, $id)
    {
        $translation = Translation::findOrFail($id);
        $answer = $request->answer;
        $isEnglish = $request->is_english;
        $message = "wrong";
        if (($isEnglish && $answer == $translation->serbian) || (!$isEnglish && $answer == $translation->english)) {
            $message = "correct";
        }
        return response()->json(["message" => $message]);
    }
}
