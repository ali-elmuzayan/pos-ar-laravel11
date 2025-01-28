<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Http\Traits\handleImage;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // start the transaction
        DB::beginTransaction();

        try {

            // update the data except the logo
            $setting->update($request->except('logo'));

            if ($request->hasFile('logo')) {
                // Delete the old image if it exists
                if (!empty($setting->logo) && Storage::exists($setting->logo)) {
                    Storage::delete($setting->logo); // Use Storage::delete instead of unlink
                }

                // upload the image or throw error
                try {
                    $image = $this->uploadImage($request->file('logo'), 'uploads/setting');
                    $setting->logo = $image;
                    $setting->save(); // Save only if the logo is updated
                } catch (\Exception $e) {
                    // Handle the error (e.g., log it, return an error response)
                    Log::error('Logo upload failed: ' . $e->getMessage()); // Log the error
                    toastr()->error('حجث خطأ اثناء تحميل اللوجو');
                    return redirect()->back()->withInput();
                }

            }

            // commit the transaction
            DB::commit();

            toastr()->success('تم تحديث بيانات الاعدادات بنجاح');
            return redirect()->route('settings.index');
        } catch (\Exception $e) {

            DB::rollBack();
            // Log the error
            Log::error('Error updating settings: ' . $e->getMessage());


            toastr()->error('حدث مشكلة اثناء تحديث الاعدادات');
            return redirect()->back();
        }
    }


    // get the last back up
    public function getLatestBackup()
    {
        // Define the backup disk and directory
        $backupDisk = 'backups'; // The disk name defined in your backup configuration
        $backupDirectory = 'Laravel'; // The directory where backups are stored (empty if root)

        // Get all backup files
        $backupFiles = Storage::disk($backupDisk)->files($backupDirectory);

        // Sort files by last modified date (newest first)
        usort($backupFiles, function ($a, $b) use ($backupDisk) {
            return Storage::disk($backupDisk)->lastModified($b) <=> Storage::disk($backupDisk)->lastModified($a);
        });

        // Get the latest backup file
        $latestBackupFile = $backupFiles[0] ?? null;

        if (!$latestBackupFile) {
            toastr()->error('لا يوجد ملفات باك اب');
            return redirect()->back();
        }

        // Return the file path or download the file
        return Storage::disk($backupDisk)->download($latestBackupFile);
    }

    // reset the setting
    public function resetSetting() {
        $setting = Setting::first();
        $setting->update([
            'name' => 'اسم الشركة',
            'logo' => 'uploads/no-logo.png',
            'description' =>'شركة متخصصة في بيع المنتجات النسائية',
            'address' => 'سمالوط غرب - شارع اسواق الاتحاد - امام تاون تيم',
            'phone' => '01010232458',
            'backup_dir' => '/backups/',
            'exchange_period' => 14,
            'return_period' => 7,
            'data_per_page' => 15,
            'currency' => 'EGP',
        ]);
        toastr()->success('تم اعادة ضبط البيانات بنجاح');
        return redirect()->route('settings.index');
    }
}
