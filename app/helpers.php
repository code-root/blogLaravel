<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

function imageUploadPost(Request $request) {
    $user_id = Auth::user()->id;
    $imageName = time().'-'.$user_id.'.'.$request->image->extension();
    $request->image->storeAs('public/images', $imageName);
    return $imageName;
}
