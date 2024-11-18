<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Storage;

class GenerateImageController extends Controller
{
    
    public function generateFace(Request $request)
    {
        $formDataString = '';
        foreach ($request->all() as $key => $value) {
            $formDataString .= $key . ':-' . str_replace(' ', '-', trim($value)) . '-';
        }
        $formDataString = rtrim($formDataString, '-'); // Remove the trailing dash

        $apiURL = 'https://image.pollinations.ai/prompt/';

        $newImageUrl = $apiURL . 'full-headshot-composite-drawing-following-these-descriptions:-' . $formDataString . '-in-a-white-background'; // Replace with the new image URL

        $ch = curl_init($newImageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        } else {
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($statusCode === 200) {
                curl_close($ch);
                return response()->json(['imageUrl' => $newImageUrl], 200);
            } else {
                curl_close($ch);
                return response()->json(['error' => 'Failed to load URL'], $statusCode);
            }
        }
    }

}

