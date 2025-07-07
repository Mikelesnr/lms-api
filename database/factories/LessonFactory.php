<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $videoLibrary = [
            [
                'title' => 'Random.Code() - AutoDeconstruct and Transpire',
                'description' => 'Debugging a source generator and adding a new analyzer to Transpire.',
                'video_url' => 'https://www.youtube.com/embed/bWhsmwS0Jec',
            ],
            [
                'title' => 'Live coding stream: Solving random coding challenge',
                'description' => 'Solving random challenges from Codewars, HackerRank, and LeetCode.',
                'video_url' => 'https://www.youtube.com/embed/461MK_gLi3c',
            ],
            [
                'title' => 'Coding in a Random Programming Language Everyday',
                'description' => 'Exploring a new programming language every day—chaotic and fun!',
                'video_url' => 'https://www.youtube.com/embed/OGJPLh7O2iI',
            ],
            [
                'title' => 'Random Coding Challenge - Introduction',
                'description' => 'Welcome to a series of random programming and software engineering challenges.',
                'video_url' => 'https://www.youtube.com/embed/796ocu55xfg',
            ],
            [
                'title' => 'Random Coding Stream',
                'description' => 'Unscripted programming session covering allocators, encoders, and more.',
                'video_url' => 'https://www.youtube.com/embed/hKAbxgV8K3o',
            ],
            [
                'title' => 'Random.Code() - Writing a Suppressor in Rocks, Part 2',
                'description' => 'Continuing work on a suppressor in Rocks with deep dive into diagnostics.',
                'video_url' => 'https://www.youtube.com/embed/0izdMIK-org',
            ],
            [
                'title' => 'Random.Code() - More ExceptionalStatistics Goodness',
                'description' => 'Exploring InstantAPIs and logging strategies in ExceptionalStatistics.',
                'video_url' => 'https://www.youtube.com/embed/ONxbcXp_WeU',
            ],
            [
                'title' => 'Random - Coding Basics',
                'description' => 'A beginner-friendly intro to basic coding concepts.',
                'video_url' => 'https://www.youtube.com/embed/01OteQY7OW8',
            ],
            [
                'title' => '20 Programming Projects That Will Make You A God At Coding',
                'description' => 'Project ideas to level up your skills and build a killer portfolio.',
                'video_url' => 'https://www.youtube.com/embed/jTJvyKZDFsY',
            ],
            [
                'title' => 'Learn How To Cook in Under 25 Minutes',
                'description' => 'A fast-paced fundamentals guide for beginners by Joshua Weissman.',
                'video_url' => 'https://www.youtube.com/embed/P6W8kwmwcno',
            ],
            [
                'title' => 'I Tested Every YouTuber Tech Product',
                'description' => 'Mrwhosetheboss reviews gear from top creators including MKBHD.',
                'video_url' => 'https://www.youtube.com/embed/MBQBY9b6OAU',
            ],
            // 🍳 Cooking — Joshua Weissman
            [
                'title' => 'Learn How To Cook in Under 25 Minutes',
                'description' => 'A fast-paced fundamentals guide for beginners by Joshua Weissman.',
                'video_url' => 'https://www.youtube.com/embed/P6W8kwmwcno',
            ],
            [
                'title' => 'I Tried 1,000,000 Years Of Food',
                'description' => 'A whimsical tour through culinary history with Joshua Weissman.',
                'video_url' => 'https://www.youtube.com/embed/2RE5F0e4gVc',
            ],
            [
                'title' => 'The 5 Meals Anyone Can Make',
                'description' => 'Comfort meals with minimal effort—Joshua-style.',
                'video_url' => 'https://www.youtube.com/embed/bwapUJcTVeU',
            ],

            // 🍖 Guga Foods
            [
                'title' => 'I Cooked 100 Years of Steaks',
                'description' => 'Guga explores the evolution of steak cooking techniques over a century.',
                'video_url' => 'https://www.youtube.com/embed/CtZ0MXc_g4U',
            ],
            [
                'title' => 'Maximum Steak Crispiness Unlocked!',
                'description' => 'An experimental deep dive into extreme steak textures with Guga.',
                'video_url' => 'https://www.youtube.com/embed/VNS7R2mPkcU',
            ],
            [
                'title' => 'I Cooked Every Food YouTuber’s #1 Meal!',
                'description' => 'Guga recreates signature dishes from fellow food creators.',
                'video_url' => 'https://www.youtube.com/embed/DfGtlRNnUmU',
            ],

            // 🍝 Nick DiGiovanni
            [
                'title' => 'Master Cooking In Under 20 Minutes',
                'description' => 'Nick distills culinary knowledge into one fast, flavor-packed episode.',
                'video_url' => 'https://www.youtube.com/embed/6LDswBUN21o',
            ],
            [
                'title' => 'Cooking Meals For Random Strangers',
                'description' => 'Nick hits the streets to spread good food and better vibes.',
                'video_url' => 'https://www.youtube.com/embed/0-Gyuj2UomI',
            ],
            [
                'title' => 'Cooking Challenge vs Dude Perfect',
                'description' => 'Wild cook-off between Nick and the trick-shot crew.',
                'video_url' => 'https://www.youtube.com/embed/vgPJZ1ktT50',
            ],

            // 💻 Mrwhosetheboss
            [
                'title' => 'You’re Wasting Money on Tech.',
                'description' => 'A wake-up call about what really matters in your tech spending.',
                'video_url' => 'https://www.youtube.com/embed/De7s-IB_DAw',
            ],
            [
                'title' => 'I Tested Every YouTuber Tech Product',
                'description' => 'Reviewing tech gear from top creators including MKBHD.',
                'video_url' => 'https://www.youtube.com/embed/MBQBY9b6OAU',
            ],
            [
                'title' => 'I Bought the World’s RAREST Tech!',
                'description' => 'A showcase of bizarre, rare, and almost mythical gadgets.',
                'video_url' => 'https://www.youtube.com/embed/AClfhmJYyNc',
            ],

            // 🔧 Marques Brownlee (MKBHD)
            [
                'title' => 'The Worst Product I’ve Ever Reviewed… For Now',
                'description' => "MKBHD's hot take on the Humane AI pin—and why it flopped.",
                'video_url' => 'https://www.youtube.com/embed/TitZV6k8zfA',
            ],
            [
                'title' => '51 Tiny Essentials We ACTUALLY Use | Everyday Tech (2025)',
                'description' => 'Compact and powerful tools to upgrade your everyday.',
                'video_url' => 'https://www.youtube.com/embed/x0tgdtpjnpc',
            ],
            [
                'title' => 'Talking Tech and AI with Tim Cook!',
                'description' => 'MKBHD sits down with Apple’s CEO to discuss privacy, AI, and the future.',
                'video_url' => 'https://www.youtube.com/embed/pMX2cQdPubk',
            ],
            [
                'title' => 'The Complete Python Course For Beginners',
                'description' => 'A 6-hour deep dive into Python fundamentals, from variables to OOP.',
                'video_url' => 'https://www.youtube.com/embed/sxTmJE4k0ho',
            ],
            [
                'title' => '9 HOURS of Python Projects - From Beginner to Advanced',
                'description' => 'Build 21 real-world Python projects, from quiz games to automation tools.',
                'video_url' => 'https://www.youtube.com/embed/NpmFbWO6HPU',
            ],
            [
                'title' => 'How I Would Learn To Code FAST In 2024',
                'description' => 'Tim’s roadmap for mastering programming efficiently in the AI era.',
                'video_url' => 'https://www.youtube.com/embed/LOGuP81D8wc',
            ],
            [
                'title' => 'Learn JavaScript Interactively in NEW freeCodeCamp.org Curriculum',
                'description' => 'Explore the updated JS certification with hands-on projects and challenges.',
                'video_url' => 'https://www.youtube.com/embed/n8mNX2YqkUs',
            ],
            [
                'title' => 'FreeCodeCamp HTML Full Course',
                'description' => 'Master HTML from scratch with this beginner-friendly walkthrough.',
                'video_url' => 'https://www.youtube.com/embed/StJsk_3UQDU',
            ],
            [
                'title' => 'freeCodeCamp Turns 10 & Major Certification Updates',
                'description' => 'A look at the platform’s evolution and new fullstack developer curriculum.',
                'video_url' => 'https://www.youtube.com/embed/1fZ0hTX-ut4',
            ],
            [
                'title' => 'My Unconventional Coding Story | Self-Taught',
                'description' => 'Travis shares his journey from burnout to software engineer and DevRel.',
                'video_url' => 'https://www.youtube.com/embed/eFJGyT3C-Y0',
            ],
            [
                'title' => '8 Years A Developer | What I’ve Learned | Self-Taught',
                'description' => 'Hard-earned lessons from a self-taught dev after nearly a decade in tech.',
                'video_url' => 'https://www.youtube.com/embed/3YqJU3WSixI',
            ],
            [
                'title' => '40 Life Lessons from a 40-Year-Old Developer',
                'description' => 'A mix of career, mindset, and life advice from a seasoned coder.',
                'video_url' => 'https://www.youtube.com/embed/AzczASDeXvU',
            ],
            [
                'title' => 'I Upgraded My Car With Open-Source AUTOPILOT',
                'description' => 'Linus and Jake retrofit a Toyota Corolla with open-source self-driving tech.',
                'video_url' => 'https://www.youtube.com/embed/xdmxM-v4KQg',
            ],
            [
                'title' => 'The Small Problems That Make Tech Awful',
                'description' => 'A hilarious rant on the little UX issues that ruin modern tech.',
                'video_url' => 'https://www.youtube.com/embed/6wgHq9NZru0',
            ],
            [
                'title' => 'My Assistant Became My Boss for the Day - AMD $5000 Upgrade',
                'description' => 'Linus gets demoted while his assistant builds a monster PC.',
                'video_url' => 'https://www.youtube.com/embed/g3Y0lBoOrEg',
            ],
        ];

        $video = $videoLibrary[array_rand($videoLibrary)];

        return [
            'title' => $video['title'],
            'content' => $video['description'],
            'video_url' => $video['video_url'],
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}
