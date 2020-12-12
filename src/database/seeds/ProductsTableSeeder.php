<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([[
            'organizer_id' => 1,
            'category_id' => 1,
            'name' => '魔王城からの脱出',
            'kana_name' => 'まおうじょうからのだっしゅつ',
            'phrase' => '魔王は倒した、だけど城から出られない！？',
            'website' => 'https://realdgame.jp/event/maoujou.html',
            'image_name' => 'demon_castle.jpg',
        ], [
            'organizer_id' => 2,
            'category_id' => 2,
            'name' => 'Analyze - アナライズ -',
            'kana_name' => 'あならいず',
            'phrase' => 'あなたたちはゲームの世界へ飛び込んだ！',
            'website' => 'https://tumbleweedjp.info/base_shimokita/event_description.html?event_id=38',
            'image_name' => 'eve_Analyze.jpg',
        ], [
            'organizer_id' => 3,
            'category_id' => 3,
            'name' => '忍里特別任務 #006 ナルト・我愛羅篇',
            'kana_name' => 'しのびさととくべつにんむ 6 なると・があらへん',
            'phrase' => null,
            'website' => 'https://nazoxnazo.com/shinobizato_ninmu_gaara/',
            'image_name' => 'naruto006.jpg',
        ], [
            'organizer_id' => 4,
            'category_id' => 4,
            'name' => 'PHANTOM',
            'kana_name' => 'ふぁんとむ',
            'phrase' => null,
            'website' => 'https://yodaka.info/event/2011phantom',
            'image_name' => 'phantom.png',
        ], [
            'organizer_id' => 5,
            'category_id' => 1,
            'name' => '古代遺跡からの脱出2',
            'kana_name' => 'こだいいせきからのだっしゅつ2',
            'phrase' => '古の遺跡に隠されし部屋から脱出せよ',
            'website' => 'https://noescape.co.jp/shinjuku/sp/escape-theme/ancient-monument/',
            'image_name' => 'kodai-iseki-2.jpg',
        ]]);
    }
}
