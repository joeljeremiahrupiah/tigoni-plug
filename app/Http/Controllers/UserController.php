<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getAdminDetails()
    {
        $admindetails = User::where('user_type', 'admin')->first();
        return response(['admindetails' => $admindetails, 'status' => 200], 200);
    }

    public function getAllUsers()
    {
        $users = User::latest()->get();
        return response(['users' => $users, 'status' => 200], 200);
    }

    public function updateUserStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->status == 'true') {
            $user->status = 'false';
        } else if ($user->status == 'false') {
            $user->status = 'true';
        } else {
            $user->status = null;
        }
        $user->save();
        return $this->getAllUsers();
    }

    public function processProfileInformation(Request $request, $id)
    {
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $phoneOne = $request->input('phoneOne');
        $phoneTwo = $request->input('phoneTwo');
        $facebooklink = $request->input('facebooklink');
        $twitterlink = $request->input('twitterlink');
        $youtubelink = $request->input('youtubelink');

        $user = User::find($id);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('avatars', 'public');

            $user->logo = $avatarPath;
            $user->save();
        }

        $user->name =  $fullname;
        $user->email =  $email;
        $user->facebooklink =  $facebooklink;
        $user->twitterlink =  $twitterlink;
        $user->youtubelink =  $youtubelink;
        $user->phoneOne =  $phoneOne;
        $user->phoneTwo =  $phoneTwo;
        $user->save();

        return response()->json(['user' => $user, 'status' => 200], 200);
    }
}
