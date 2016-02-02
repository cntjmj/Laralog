<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['id'=>8, 'name'=>'Social', 'permalink'=>'social',
             'order'=>1, 'status'=>'active', 'created_at'=>'2016-01-06 04:08:42', 'updated_at'=>'2016-01-06 04:10:32'],
            ['id'=>9, 'name'=>'Politics', 'permalink'=>'politics',
             'order'=>2, 'status'=>'active', 'created_at'=>'2016-01-06 04:11:48', 'updated_at'=>'2016-01-06 04:11:48'],
            ['id'=>10, 'name'=>'Business', 'permalink'=>'business-economics-economy',
             'order'=>3, 'status'=>'active', 'created_at'=>'2016-01-06 04:12:19', 'updated_at'=>'2016-01-11 09:26:58'],
            ['id'=>11, 'name'=>'World', 'permalink'=>'world',
             'order'=>4, 'status'=>'active', 'created_at'=>'2016-01-06 04:12:40', 'updated_at'=>'2016-01-06 04:12:40'],
            ['id'=>12, 'name'=>'Science &amp; Tech', 'permalink'=>'science-technology',
             'order'=>5, 'status'=>'active', 'created_at'=>'2016-01-06 04:15:36', 'updated_at'=>'2016-01-11 09:26:06']
        ]);
    }
}
