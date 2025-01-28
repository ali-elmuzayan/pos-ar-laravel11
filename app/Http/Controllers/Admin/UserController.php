<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Traits\handleImage;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use handleImage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest()->paginate(AppServiceProvider::PAGINATION_LIMIT);
        $counter = 1;
        return view('admin.pages.users.index', compact('data', 'counter'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {



        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

//        Auth::login($user);
        toastr()->success('تم انشاء مستخدم جديد بنجاح');
        return redirect()->route('users.index');
    }



    /**
     * show edit form
     */
    public function edit(User $user) {

        return view('admin.pages.users.edit', compact('user'));
    }


    /**
     * update the user data
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {

        // start the transaction
        DB::beginTransaction();
        try {
            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($user->image && Storage::exists($user->image)) {
                    Storage::delete($user->image);
                }

                // Upload the new image
                $imagePath = $this->uploadImage($request->file('image'), 'uploads/users');
                $user->image = $imagePath;
            }

            // Update user data except password and image
            $user->update($request->except(['image']));

            // Commit the transaction
            DB::commit();

            // Notify and redirect
            toastr()->success('تم تعديل بيانات العميل بنجاح');
            return redirect()->route('users.index');
        }catch (\Exception $exception){
            // rollback with error message
            DB::rollBack();

            //Notify and redirect to the users.index
            toastr()->error('حدث مشكلة اثناء التحديث');
            return redirect()->route('users.index');

        }


    }


    /**
     * change the user password
     */
    public function updatePassword(ChangePasswordRequest $request, User $user): RedirectResponse
    {


        $user->password = Hash::make($request->password);
        $user->save();
        toastr()->success('تم تحديث كلمة مرور المستخدم بنجاح');
        return redirect()->route('users.index');
    }


    public function destroy(Request $request)
    {

        $user = User::findOrFail($request->id);
        if (!empty($user->image)){
            unlink($user->image);
        }
        $user->delete();
        return response()->json(['success' => true, 'message' => 'تم حذف المستخدم']);

    }

}
