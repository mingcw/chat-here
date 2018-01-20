<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('rooms')->delete();
        
        \DB::table('rooms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '1号房间',
                'description' => '来自官方的测试',
                'capacity' => 14,
                'number' => 0,
                'username' => '萌新',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '2号房间',
                'description' => '没错还是测试的',
                'capacity' => 15,
                'number' => 0,
                'username' => '萌新',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '3号房间',
                'description' => '这个房间可好了',
                'capacity' => 15,
                'number' => 0,
                'username' => '乌龟',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '4号房间',
                'description' => '可以的，这个房间可以的',
                'capacity' => 16,
                'number' => 2,
                'username' => '老司机',
            ),
        ));
        
        
    }
}