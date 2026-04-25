<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::query()->upsert([
            [
                'id' => 1,
                'name' => 'Tai nghe AirBeat Pro',
                'category' => 'Điện tử',
                'price' => 890000,
                'old_price' => 1290000,
                'rating' => 4.8,
                'sold' => '8.4k',
                'color' => 'from-indigo-500 to-violet-600',
                'emoji' => '🎧',
                'desc' => 'Chống ồn chủ động, pin 32 giờ, Bluetooth 5.3, âm bass mạnh mẽ cho làm việc, học tập và giải trí.',
            ],
            [
                'id' => 2,
                'name' => 'Bình giữ nhiệt ZenBottle',
                'category' => 'Nhà cửa',
                'price' => 320000,
                'old_price' => 480000,
                'rating' => 4.7,
                'sold' => '5.1k',
                'color' => 'from-emerald-500 to-lime-500',
                'emoji' => '🥤',
                'desc' => 'Giữ nóng lạnh 12 giờ, chất liệu thép không gỉ, nắp chống tràn, phù hợp văn phòng và du lịch.',
            ],
        ], ['id']);
    }
}
