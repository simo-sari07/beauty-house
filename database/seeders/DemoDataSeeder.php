<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $categories = [
            ['name' => 'Makeup', 'slug' => 'makeup', 'description' => 'Face, Eyes, Lips, and more.'],
            ['name' => 'Skincare', 'slug' => 'skincare', 'description' => 'Cleansers, Toners, Serums, and more.'],
            ['name' => 'Hair Care', 'slug' => 'hair-care', 'description' => 'Shampoo, Conditioner, Treatments.'],
            ['name' => 'Fragrance', 'slug' => 'fragrance', 'description' => 'Perfumes and Body Mists.'],
            ['name' => 'Body Care', 'slug' => 'body-care', 'description' => 'Lotions, Scrubs, and Shower Gels.'],
            ['name' => 'Beauty Tools', 'slug' => 'beauty-tools', 'description' => 'Brushes, Sponges, and Tools.'],
            ['name' => 'Offers & Promotions', 'slug' => 'offers', 'description' => 'Best sellers and discounts.'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert(array_merge($cat, [
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        // 2. Create Users (3 Admins + Normal Users)
        $admins = [
            ['name' => 'Admin One', 'email' => 'admin1@beautyhouse.com', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '1234567890'],
            ['name' => 'Admin Two', 'email' => 'admin2@beautyhouse.com', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '1234567890'],
            ['name' => 'Admin Three', 'email' => 'admin3@beautyhouse.com', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '1234567890'],
        ];

        foreach ($admins as $admin) {
            DB::table('users')->insert(array_merge($admin, [
                'email_verified_at' => now(),
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        $users = [
            ['name' => 'Sarah Doe', 'email' => 'sarah@example.com', 'password' => Hash::make('password'), 'role' => 'user', 'phone' => '555123456'],
            ['name' => 'Emily Rose', 'email' => 'emily@example.com', 'password' => Hash::make('password'), 'role' => 'user', 'phone' => '555987654'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert(array_merge($user, [
                'email_verified_at' => now(),
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        // 3. Create Products (20+ items)
        $catIds = DB::table('categories')->pluck('id', 'slug');

        $products = [
            // Makeup
            ['category_id' => $catIds['makeup'], 'name' => 'Velvet Matte Lipstick', 'slug' => 'velvet-matte-lipstick', 'price' => 25.00, 'stock' => 100, 'description' => 'Long-lasting matte lipstick in rose red.'],
            ['category_id' => $catIds['makeup'], 'name' => 'Liquid Foundation', 'slug' => 'liquid-foundation', 'price' => 35.00, 'stock' => 50, 'description' => 'Full coverage foundation for all skin tones.'],
            ['category_id' => $catIds['makeup'], 'name' => 'Volumizing Mascara', 'slug' => 'volumizing-mascara', 'price' => 18.00, 'stock' => 80, 'description' => 'Blackest black mascara for dramatic lashes.'],
            ['category_id' => $catIds['makeup'], 'name' => 'Rose Blush Palette', 'slug' => 'rose-blush-palette', 'price' => 28.00, 'stock' => 40, 'description' => 'Three shades of pink for a natural glow.'],
            ['category_id' => $catIds['makeup'], 'name' => 'Eyeliner Pen', 'slug' => 'eyeliner-pen', 'price' => 15.00, 'stock' => 120, 'description' => 'Waterproof liquid eyeliner with precision tip.'],
            
            // Skincare
            ['category_id' => $catIds['skincare'], 'name' => 'Hydrating Face Cream', 'slug' => 'hydrating-face-cream', 'price' => 45.00, 'stock' => 60, 'description' => 'Deeply moisturizing cream with hyaluronic acid.'],
            ['category_id' => $catIds['skincare'], 'name' => 'Vitamin C Serum', 'slug' => 'vitamin-c-serum', 'price' => 38.00, 'stock' => 70, 'description' => 'Brightening serum for radiant skin.'],
            ['category_id' => $catIds['skincare'], 'name' => 'Gentle Foam Cleanser', 'slug' => 'gentle-foam-cleanser', 'price' => 22.00, 'stock' => 90, 'description' => 'Removes impurities without drying skin.'],
            ['category_id' => $catIds['skincare'], 'name' => 'Rose Water Toner', 'slug' => 'rose-water-toner', 'price' => 20.00, 'stock' => 85, 'description' => 'Soothing toner with real rose petals.'],
            ['category_id' => $catIds['skincare'], 'name' => 'Clay Face Mask', 'slug' => 'clay-face-mask', 'price' => 30.00, 'stock' => 45, 'description' => 'Detoxifying mask for pore cleansing.'],

            // Hair Care
            ['category_id' => $catIds['hair-care'], 'name' => 'Argan Oil Shampoo', 'slug' => 'argan-oil-shampoo', 'price' => 18.00, 'stock' => 100, 'description' => 'Nourishing shampoo for dry hair.'],
            ['category_id' => $catIds['hair-care'], 'name' => 'Keratin Conditioner', 'slug' => 'keratin-conditioner', 'price' => 18.00, 'stock' => 100, 'description' => 'Smooths and strengthens hair.'],
            ['category_id' => $catIds['hair-care'], 'name' => 'Hair Repair Mask', 'slug' => 'hair-repair-mask', 'price' => 25.00, 'stock' => 50, 'description' => 'Intensive treatment for damaged hair.'],

            // Fragrance
            ['category_id' => $catIds['fragrance'], 'name' => 'Flora Eau de Parfum', 'slug' => 'flora-eau-de-parfum', 'price' => 85.00, 'stock' => 30, 'description' => 'Floral scent with notes of jasmine and rose.'],
            ['category_id' => $catIds['fragrance'], 'name' => 'Vanilla Body Mist', 'slug' => 'vanilla-body-mist', 'price' => 15.00, 'stock' => 150, 'description' => 'Sweet and warm vanilla fragrance.'],

            // Body Care
            ['category_id' => $catIds['body-care'], 'name' => 'Shea Butter Lotion', 'slug' => 'shea-butter-lotion', 'price' => 12.00, 'stock' => 200, 'description' => 'Daily moisturizer for soft skin.'],
            ['category_id' => $catIds['body-care'], 'name' => 'Coffee Body Scrub', 'slug' => 'coffee-body-scrub', 'price' => 20.00, 'stock' => 60, 'description' => 'Exfoliating scrub for smooth skin.'],

            // Beauty Tools
            ['category_id' => $catIds['beauty-tools'], 'name' => 'Makeup Brush Set', 'slug' => 'makeup-brush-set', 'price' => 35.00, 'stock' => 40, 'description' => '10-piece professional brush set.'],
            ['category_id' => $catIds['beauty-tools'], 'name' => 'Beauty Sponge', 'slug' => 'beauty-sponge', 'price' => 8.00, 'stock' => 300, 'description' => 'Soft sponge for flawless blending.'],
            ['category_id' => $catIds['beauty-tools'], 'name' => 'LED Mirror', 'slug' => 'led-mirror', 'price' => 50.00, 'stock' => 20, 'description' => 'Lighted vanity mirror for makeup application.'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert(array_merge($product, [
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ]));
        }
    }
}
