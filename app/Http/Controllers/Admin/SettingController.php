<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Traits\handleImage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    use handleImage;

    public function index()
    {
        return view('admin.pages.settings.index' );
    }


    // show edit setting form
    public function edit() {
        return view('admin.pages.settings.edit');
    }


    // update the setting data
    public function update(SettingRequest $request, Setting $setting) {
        // update the data except the logo
        $setting->update($request->except('logo'));


        if ($request->hasFile('logo')) {
            // Delete the old image if it exists
            if (!empty($setting->logo) && Storage::exists($setting->logo)) {
                unlink($setting->logo);
            }
          // upload the image or throw error
            try {
                $image = $this->uploadImage($request->file('logo'), 'uploads/setting');
                $setting->logo = $image;
                $setting->save(); // Save only if the logo is updated
            } catch (\Exception $e) {
                // Handle the error (e.g., log it, return an error response)
                return redirect()->back()->withErrors(['logo' => 'Failed to upload logo.']);
            }

        }

        return redirect()->route('settings.index');
    }

}
