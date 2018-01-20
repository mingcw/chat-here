<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => '萌新',
                'password' => '54723848d157e71f45d1aee271a3b024',
                'token' => 'bab1479f3b85b3bd92d98f28b6b3be36',
                'lastloginip' => '127.0.0.1',
                'lastlogintime' => 1516353632,
            ),
            1 => 
            array (
                'id' => 2,
                'username' => '乌龟',
                'password' => '54723848d157e71f45d1aee271a3b024',
                'token' => 'd1e96e0f9383117aaefc6f91d014dce9',
                'lastloginip' => '127.0.0.1',
                'lastlogintime' => 1516364261,
            ),
            2 => 
            array (
                'id' => 3,
                'username' => '老司机',
                'password' => '54723848d157e71f45d1aee271a3b024',
                'token' => '1ec82d6c52b6c3a872075f5a33e8e596',
                'lastloginip' => '127.0.0.1',
                'lastlogintime' => 1516387132,
            ),
            3 => 
            array (
                'id' => 4,
                'username' => '诸葛村夫',
                'password' => '54723848d157e71f45d1aee271a3b024',
                'token' => '4f703fd50c48c73d99a936e6123ab064',
                'lastloginip' => '127.0.0.1',
                'lastlogintime' => 1516449465,
            ),
        ));
        
        
    }
}