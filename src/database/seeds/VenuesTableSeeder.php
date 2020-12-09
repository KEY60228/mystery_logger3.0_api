<?php

use Illuminate\Database\Seeder;

class VenuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('venues')->insert([[
            'organizer_id' => 1,
            'name' => 'アジトオブスクラップ東新宿GUNKAN',
            'kana_name' => 'あじとおぶすくらっぷ ひがししんじゅく ぐんかん',
        ], [
            'organizer_id' => 2,
            'name' => 'タンブルウィードナゾスペース',
            'kana_name' => 'たんぶるうぃーどなぞすぺーす',
        ], [
            'organizer_id' => 3,
            'name' => '〜NARUTO＆BORUTO 忍里〜',
            'kana_name' => 'なるとあんどぼると しのびざと',
        ], [
            'organizer_id' => 4,
            'name' => 'オンライン',
            'kana_name' => 'オンライン',
        ], [
            'organizer_id' => 5,
            'name' => 'NoEscape 新宿店',
            'kana_name' => 'のーえすけーぷ しんじゅくてん',
        ]]);
    }
}
