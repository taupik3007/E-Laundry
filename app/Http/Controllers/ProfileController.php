<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function edit_photo(Request $request): View
    {
        $user = $request->user();
        if ($user->hasRole('owner')) {
            $layout = 'owner.master';
            $routeName = 'owner.profile.update';
            
        } elseif ($user->hasRole('employee')) {
            $layout = 'employee.master';
            $routeName = 'employee.profile.update';
        } elseif ($user->hasRole('customer')) {
            $layout = 'customer.master';
            $routeName = 'customer.profile.update';
        } else {
            $layout = 'layouts.app'; 
            $routeName = 'profile.update';// default
        }
        return view('profile.edit2', [
            'user' => $request->user(), 
            'layout'=>$layout,
            'routeName'=>$routeName,
            
        ]);
    }

    public function update_photo(Request $request)
    {
        $user = Auth::user();
    
        // UPDATE FOTO PROFIL
if ($request->croppedImage || $request->hasFile('profile_photo')) {

    // Hapus foto lama terlebih dulu jika ada
    if ($user->usr_profile_photo && Storage::disk('public')->exists($user->usr_profile_photo)) {
        Storage::disk('public')->delete($user->usr_profile_photo);
    }

    // Jika ada file hasil crop (base64)
    if ($request->croppedImage) {
        $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->croppedImage);

        $imageName = 'photo-profile/' . uniqid() . '.png';
        Storage::disk('public')->put($imageName, base64_decode($image));

        $user->usr_profile_photo = $imageName;
    }

    // Jika user upload file biasa tanpa crop
    elseif ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('photo-profile', 'public');
        $user->usr_profile_photo = $path;
    }
}

    
        // UPDATE MANUAL
        $user->usr_name       = $request->usr_name;
        $user->usr_nik        = $request->usr_nik;
        $user->email          = $request->email;
        $user->usr_birthplace = $request->usr_birthplace;
        $user->usr_birthdate  = $request->usr_birthdate;
        $user->usr_telephone  = $request->usr_telephone;
        $user->usr_address    = $request->usr_address;
    
        // dd($user);
        $user->save();
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
    
    


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
