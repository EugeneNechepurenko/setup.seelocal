<?php

namespace App\Http\Controllers;

use App\User;
use App\CompaignSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompaignController extends Controller {
    public function CompaignSaveParams (Request $request) {
        $result = CompaignSettings::saveSettings($request);
        return response()->json($result);
    }

    public function Upload (Request $request) {
        $fileName = date('YmdHis') . '.png';
        $path = public_path() . '/images/uploads/';
        $request->file('image')->move($path, $fileName);
        return $fileName;
    }
}
