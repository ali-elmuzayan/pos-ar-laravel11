<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BackupRequest;

class BackupController extends Controller
{
    public function setBackupDir(BackupRequest $request){

        return redirect()->back()->with('success', 'Backup directory updated successfully');
    }
}
