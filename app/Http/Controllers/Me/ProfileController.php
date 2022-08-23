<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Me\Profile\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User data fetched successfully.',
            ],
            'data' => [
                'email' => $user->email,
                'name' => $user->name,
                'picture' => $user->picture,
            ],
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('picture'))
            $validated['picture'] = $request->file('picture')->store('profile-pictures', 'public');

        $user = User::find(auth()->id());

        $update = $user->update($validated);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User data updated successfully.',
            ],
            'data' => [
                'email' => $user->email,
                'name' => $user->name,
                'picture' => $user->picture,
            ],
        ]);
    }
}
