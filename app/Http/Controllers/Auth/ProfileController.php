<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Traits\handleImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use handleImage;
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }


    // change the password
    public function editPassword(Request $request): View
    {
        return view('admin.pages.profile.edit-password', [
            'user' => $request->user(),
        ]);
    }

    // update the password
    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.edit.password');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        // start a database transaction
        DB::beginTransaction();

        try{
            // Get the authenticated user
            $user = $request->user();

            // update user data except the image
            $user->update($request->validated());

            // Reset email verification if email is updated
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // handle image upload
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if (!empty($user->image) && Storage::exists($user->image)) {
                    Storage::delete($user->image);
                }

                // upload the new image
                $image = $this->uploadImage($request->file('image'), 'uploads/users');
                $user->image = $image;
            }

            $user->save();

            // commit the transaction
            DB::commit();

            return redirect()->route('profile.edit')->with('success', 'profile updated successfully');

        }catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return  redirect()->route('profile.edit')
                    ->with('error', 'An error occurred while updating your profile ');
        }
    }


}
