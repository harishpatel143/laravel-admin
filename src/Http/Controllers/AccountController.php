<?php

namespace Multidots\Admin\Http\Controllers;

use Multidots\Admin\Http\Controllers\Controller;
use Multidots\Admin\Models\Administrator;
use Auth;
use Multidots\Admin\Helpers\MDImageHelper;
use Multidots\Admin\Http\Requests\AdministratorRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    /**
     * Update logged in administrator profile
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(AdministratorRequest $request)
    {
        try {
            $admin = Administrator::findOrFail(Auth::guard('admin')->user()->id);
            $updateData = $request->all();
            // Change Password
            if (!empty($request->password) && !empty($request->current_password)) {
                if (Hash::check($request->current_password, $admin->password)) {
                    $updateData['password'] = $request->password;
                    if ($admin->update($updateData)) {
                        $request->session()->flash('success', 'Password has been updated successfully.');
                        auth()->login($admin);
                        return redirect()->route('home');
                    } else {
                        $request->session()->flash('error', 'Password could not be updated. Please, try again.');
                    }
                } else {
                    $validator = Validator::make($request->all(), []);
                    $validator->errors()->add('current_password', 'Your current password is incorrect, please try again.');
                    return redirect()->route('update-profile')->withErrors($validator)->withInput();
//                    return redirect('admin/account/profile')->withErrors($validator)->withInput();
                }
            }

            // Update User Avatar
            if (!empty($request->file('avatar'))) {
                $this->deleteUserImage($admin->avatar);
                $updateData['avatar'] = $this->uploadUserImage($request);
                if ($admin->update($updateData)) {
                    $request->session()->flash('success', 'Avatar has been updated successfully.');
//                    
                    return redirect()->route('home');
                } else {
                    $request->session()->flash('error', 'Avatar could not be updated. Please, try again.');
                }
            }

            // Update User Information
            if ($admin->update($updateData)) {
                $request->session()->flash('success', 'Profile has been updated successfully.');

                return redirect()->route('home');
            } else {
                $request->session()->flash('error', 'Profile could not be updated. Please, try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin.errors.404');
        }
    }

    /**
     * Delete user's profile image
     * 
     * @param array $imageName image name
     */
    public function deleteUserImage($imageName)
    {
        if ($imageName != '' && file_exists(config('admin.ADMIN_CONST.ADMIN_IMAGE_PATH') . $imageName)) {
            File::delete(config('admin.ADMIN_CONST.ADMIN_IMAGE_PATH') . $imageName);
        }
    }

    /**
     * Upload user's profile image
     * 
     * @param array $imageArray image array
     */
    public function uploadUserImage($imageArray)
    {
        if (!empty($imageArray->file('avatar')->getFilename()) && $imageArray->file('avatar')->getError() == 0) {
            //Upload image
//            MDImageHelper::setupVars(['uploadBasePath' => config('admin.ADMIN_CONST.ADMIN_IMAGE_PATH')]);
            $uploadedImage = MDImageHelper::uploadImage($imageArray->file('avatar'));
            $adminImage = basename($uploadedImage['imageName']);

            return $adminImage;
        }
    }

    /**
     * Check email for user
     * 
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkEmail(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $checkEmail = Administrator::active()->where([['id', '<>', Auth::guard('admin')->user()->id], ['email', '=', $request->email]]);

        $flag = $checkEmail->count() > 0 ? 'false' : 'true';

        return $flag;
    }

    /**
     * Check username for user
     * 
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkUsername(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $checkUsername = Administrator::active()->where([['id', '<>', Auth::guard('admin')->user()->id], ['username', '=', $request->username]]);
//        $checkUsername = Administrator::active()->where('username', $request['username']);
//        if (!empty($request['id'])) {
//            $checkUsername->where('id', '<>', $request['id']);
//        }
        $flag = $checkUsername->count() > 0 ? 'false' : 'true';

        return $flag;
    }

    /**
     * Check administrator current password is wrong or correct
     * 
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkPassword(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $flag = 'true';
        $admin = Administrator::active()->select('id', 'password')->findorfail(Auth::guard('admin')->user()->id);
        if (!Hash::check($request['current_password'], $admin->password)) {
            $flag = 'false';
        }

        return $flag;
    }

}
