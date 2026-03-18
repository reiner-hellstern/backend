<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FEUserController extends Controller
{
    /**
     * Check if user and password in request matches
     *
     * @return \Illuminate\Http\Response
     */
    public function checkAuth(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $hasher = app('hash');
            if ($hasher->check($request->password, $user->password)) {
                return 200;
            } else {
                return 0;
            }
        } else {
            return 0;
        }

    }

    /**
     * Create a new Frontend User in Typo3 Database
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $user = new User();
        $user->email = 'gerald@goemmel.de';
        $user->profile_photo_path = 'photo';
        $user->name = 'Gerald Gömmel';

        $feuser = [
            'pid' => 129,
            'username' => $user->email,
            'cruser_id' => 1,
            'deleted' => 0,
            'disable' => 0,
            'starttime' => 0,
            'endtime' => 0,
            'description' => '',
            'tx_extbase_type' => 0,
            'usergroup' => 1,
            'image' => $user->profile_photo_path,
            'TSconfig' => '',
            'name' => $user->name,
            'first_name' => '',
            'last_name' => '',
            'address' => '',
            'email' => $user->email,
            'zip' => '',
            'city' => '',
        ];

        DB::connection('website')->table('fe_users')->insert($feuser);

    }

    /**
     * Update Frontend User in Typo3 Database
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $olduser, User $newuser)
    {
        //    $user = new User;
        //    $user->email = 'gerald@goemmel.de';
        //    $user->profile_photo_path = 'photo';
        //    $user->name = 'Gerald Gömmel';

        // $update = 'update feusers set username = "'.$newuser->email.'", image = "'.$newuser->profile_photo_path.'", name = "'.$newuser->name.'", email = "'.$newuser->email.'" where username = ?';

        // DB::connection('website')->table('fe_users')->update($update, [$olduser->email]);

    }

    /**
     * Delete Frontend User in Typo3 Database
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {

        $user = new User();
        $user->email = 'gerald@goemmel.de';

        DB::connection('website')->table('fe_users')->where('username', $user->email)->delete();

    }

    /**
     * Delete Frontend User in Typo3 Database
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {

        $users = User::all();

        DB::connection('website')->delete('delete from fe_users');

        foreach ($users as $user) {

            $feuser = [
                'pid' => 129,
                'username' => $user->email,
                'cruser_id' => 1,
                'deleted' => 0,
                'disable' => 0,
                'starttime' => 0,
                'endtime' => 0,
                'description' => '',
                'tx_extbase_type' => 0,
                'usergroup' => 1,
                'image' => $user->profile_photo_path,
                'TSconfig' => '',
                'name' => $user->name,
                'first_name' => '',
                'last_name' => '',
                'address' => '',
                'email' => $user->email,
                'zip' => '',
                'city' => '',
            ];

            DB::connection('website')->table('fe_users')->insert($feuser);

        }

    }
}
