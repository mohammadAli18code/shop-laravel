<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        $user = auth()->user();
        return view('app.profile.user.index' , compact('user'));
    }
     
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // گرفتن همه داده‌ها
        $data = $request->all();
 
        // فقط فیلدهایی که خالی نیستند را نگه دار
        $data = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });

        // اگر پسورد پر شده باشد، رمزگذاری کن
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        // dd($data);

        $user = auth()->user();
        if($user->update($data)){
           return redirect()->route('account.profile.edit' , auth()->user()->id)->with('success', 'اطلاعات شما با موفقیت به‌روز شد.');
 
        }else{
           return redirect()->route('account.profile.edit' , auth()->user()->id)->with('error', 'خطایی رخ داد . دوباره تلاش کنید');

        }



        ///
        ///
        ///



        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
