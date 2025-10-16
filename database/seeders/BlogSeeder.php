<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin user
        $adminUser = User::where('email', 'admin@carbonwallet.com')->first();
        
        if (!$adminUser) {
            return;
        }

        // Create sample blog posts
        $blogs = [
            [
                'title' => 'Carbon Emissions: What You Need to Know',
                'description' => 'Sustainable companies everywhere are working hard to reduce their carbon emissions.',
                'content' => 'Sustainable companies everywhere are working hard to reduce their carbon emissions. When businesses reduce their carbon footprint, it means a lot to customers who want to support environmentally responsible companies. In this comprehensive guide, we\'ll explore the key strategies that successful companies use to minimize their environmental impact while maintaining profitability.',
                'image' => null,
                'slug' => 'carbon-emissions-what-you-need-to-know',
                'is_published' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'The Future of Green Technology',
                'description' => 'Exploring innovative technologies that are shaping a sustainable future.',
                'content' => 'The future of green technology is brighter than ever. From renewable energy solutions to smart city infrastructure, innovative technologies are revolutionizing how we approach sustainability. Companies that invest in these technologies today will be the leaders of tomorrow\'s green economy.',
                'image' => null,
                'slug' => 'future-of-green-technology',
                'is_published' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Sustainable Business Practices',
                'description' => 'How modern businesses are integrating sustainability into their core operations.',
                'content' => 'Sustainable business practices are no longer optional - they\'re essential for long-term success. Companies that embrace sustainability see improved brand reputation, increased customer loyalty, and often better financial performance. This article explores practical steps businesses can take to become more sustainable.',
                'image' => null,
                'slug' => 'sustainable-business-practices',
                'is_published' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Renewable Energy Trends 2025',
                'description' => 'The latest trends and innovations in renewable energy technology.',
                'content' => 'Renewable energy is experiencing unprecedented growth in 2025. Solar and wind power are becoming more efficient and cost-effective than ever before. This article examines the latest trends, including advances in battery storage, smart grid technology, and the rise of community solar programs.',
                'image' => null,
                'slug' => 'renewable-energy-trends-2025',
                'is_published' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Carbon Footprint Reduction Strategies',
                'description' => 'Practical steps individuals and businesses can take to reduce their carbon footprint.',
                'content' => 'Reducing your carbon footprint doesn\'t have to be complicated. Simple changes in daily habits and business operations can make a significant difference. From energy-efficient lighting to sustainable transportation options, this guide provides actionable strategies for both individuals and organizations.',
                'image' => null,
                'slug' => 'carbon-footprint-reduction-strategies',
                'is_published' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Green Building Design Principles',
                'description' => 'How sustainable architecture is transforming the construction industry.',
                'content' => 'Green building design is revolutionizing the construction industry. From energy-efficient materials to smart building systems, sustainable architecture is creating buildings that are not only environmentally friendly but also more comfortable and cost-effective to operate.',
                'image' => null,
                'slug' => 'green-building-design-principles',
                'is_published' => true,
                'user_id' => $adminUser->id,
            ],
        ];

        foreach ($blogs as $blogData) {
            Blog::create($blogData);
        }
    }
}
