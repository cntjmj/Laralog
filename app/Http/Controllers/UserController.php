<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Gate;
use Validator;
use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function viewProfile(Request $request, $user_id) {
        $user = Auth::user();
        $profile = User::findOrFail($user_id);
        $navEntries = $this->buildNav("profile");
        //$script = "<script> var user_id=".$user->id."; </script>";

        return view('pages.user.profile', [
            'ngController' => 'UserProfileController',
            'title' => "User ". $user->name ."'s Profile",
            'navEntries' => $navEntries,
            //'script' => $script,
            'user' => $profile,
        ]);
    }
    
    public function updateProfile(Request $request, $user_id) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|between:4,100',
                'uploadAvatar' => 'max:1024000|mimes:jpeg,jpg,png,image/jpeg',
            ]);
        
            if ($validator->fails()) {
                //$message = ['error' => true, 'body' => implode('<br>', $validator->errors()->all())];
            	$message = implode('<br>', $validator->errors()->all());
            	throw new Exception($message);
                //return redirect()->route('userViewProfile', ['user_id' => $user_id])
                //                 ->with('scopeMessage', $message);
            }

            $profile = User::findOrFail($user_id);
            $this->authorize('update', $profile);

            $profile->name = $request->input('name');
            if ($request->hasFile('uploadAvatar')) {
                $this->processAvatar($request, $profile);
            };

            $profile->save();
            $scopeMessage = ['success' => true, 'body' => 'User profile has been successfully updated.'];

            return redirect()->route('userViewProfile', ['user_id' => $user_id])
                             ->with('scopeMessage', $scopeMessage);
        } catch (Exception $e) {
        	$scopeMessage = ['error' => true, 'body' => $e->getMessage()];
            return redirect()->route('userViewProfile', ['user_id' => $user_id])
                             ->with('scopeMessage', $scopeMessage);
        }
    }
    
    protected function processAvatar($request, $profile) {
        if ($request->hasFile('uploadAvatar')) {
            $file = $request->file('uploadAvatar');
            $mime = $file->getMimeType();
            if (0 !== strpos($mime, 'image'))
                throw new Exception("MIME Type \"$mime\" is not accepted");
            
            $ext = $file->getClientOriginalExtension();
            $dir = "avatar/".($request->user()->id%10);
            if (!file_exists($dir)) {
                mkdir($dir, 0644, true);
            }

            $fname = sprintf("%08d.%s",$request->user()->id, $ext);
            
            $profile->avatar = "$dir/$fname";
            
            $file->move($dir, $fname);
        }
    }
    
    protected function buildNav($current) {
        return collect([
            collect([
                "text"  => "profile",
                "url"   => $current=="profile"?"javascript:;":url("/user/profile"),
                "class" => $current=="profile"?"active":"",
            ]),
        ]);
    }
}
