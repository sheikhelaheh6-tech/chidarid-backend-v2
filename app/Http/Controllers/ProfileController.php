<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(UpdateProfileRequest $request){
        $user = auth()->user();
        $data = $request->validated();

        if($request->hasFile('logo')){
            $data['logo_path'] = $request->file('logo')->store('logos','public');
        }

        $user->update($data);
        return response()->json($user);
    }
}
