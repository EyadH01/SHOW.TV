<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Show;
use App\Models\Episode;

class CleanupSeeder extends Seeder
{
    /**
     * Run the database cleanup.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Starting database cleanup...');

        // Blacklist of problematic YouTube IDs (famous songs, repeated videos)
        $blacklist = [
            'dQw4w9WgXcQ', // Rickroll
            'kJQP7kiw5Fk', // Despacito
            'ZZ5LpwO-An4', // Gangnam Style
            'hTWKbfoikeg', // Nyan Cat
            '9bZkp7q19f0', // Another popular
            'y6y_4B9RnDs', // Repeated
            '2xx_6XNxxfA', // Repeated
        ];

        // Find episodes with blacklisted videos
        $blacklistedEpisodes = Episode::whereIn('youtube_video_id', $blacklist)->get();
        $this->command->info('Found ' . $blacklistedEpisodes->count() . ' episodes with blacklisted YouTube IDs');

        // Remove blacklisted episodes
        foreach ($blacklistedEpisodes as $episode) {
            $episode->delete();
        }

        // Find duplicate YouTube IDs (used in multiple episodes)
        $duplicateIds = DB::select("
            SELECT youtube_video_id, COUNT(*) as count
            FROM episodes
            WHERE youtube_video_id IS NOT NULL AND youtube_video_id != ''
            GROUP BY youtube_video_id
            HAVING count > 1
        ");

        $this->command->info('Found ' . count($duplicateIds) . ' duplicate YouTube IDs');

        // Remove episodes with duplicate IDs (keep first occurrence)
        foreach ($duplicateIds as $dup) {
            $firstEpisode = Episode::where('youtube_video_id', $dup->youtube_video_id)
                                  ->orderBy('id')
                                  ->first();

            if ($firstEpisode) {
                Episode::where('youtube_video_id', $dup->youtube_video_id)
                      ->where('id', '!=', $firstEpisode->id)
                      ->delete();
            }
        }

        // Update show descriptions with professional short ones
        $professionalDescriptions = [
            'باب الحارة' => 'مسلسل سوري تاريخي يروي قصص الحياة في أحياء دمشق القديمة وتقاليدها الأصيلة.',
            'الغربال' => 'كوميديا أردنية خفيفة تتابع مغامرات الشباب في الحياة اليومية المعاصرة.',
            'الخبز الحرام' => 'دراما اجتماعية سورية تتناول قضايا الفقر والحب والصراعات الحياتية.',
            'The Office (US)' => 'سلسلة كوميدية وثائقية عن الحياة اليومية في مكتب شركة ورق.',
            'Friends' => 'ستة أصدقاء يواجهون تحديات الحياة والحب في نيويورك.',
            'Breaking Bad' => 'معلم كيمياء مصاب بسرطان يدخل عالم تصنيع المخدرات.',
            'Game of Thrones' => 'صراع عائلات نبيلة للسيطرة على عرش الممالك السبع.',
            'Stranger Things' => 'أسرار خارقة ومخلوقات غريبة تهدد بلدة صغيرة.',
            'The Mandalorian' => 'مغامرات صياد مكافآت في أطراف المجرة البعيدة.',
            'The Crown' => 'سيرة الملكة إليزابيث الثانية وحياتها السياسية.',
            'Black Mirror' => 'قصص مستقبلية مظلمة تكشف مخاطر التكنولوجيا.',
            'The Witcher' => 'صياد وحوش يبحث عن مكانه في عالم مليء بالأساطير.',
            'Money Heist' => 'عصابة لصوص تخطط لأكبر سرقة في التاريخ.',
            'Narcos' => 'قصة تاجر مخدرات كولومبي وصراعه مع السلطات.',
            'The Boys' => 'مجموعة من المنتقمين تواجه السلطات الخارقة الفاسدة.',
            'Westworld' => 'حديقة ترفيهية مليئة بالروبوتات في عالم ما بعد الحداثة.',
            'Chernobyl' => 'حادثة كارثية في محطة تشيرنوبيل النووية.',
            'Dark' => 'أسرار زمنية تربط أربع عائلات في بلدة ألمانية.',
            'House of Cards' => 'سياسي طموح يخطط للوصول إلى السلطة بأي ثمن.',
            'True Detective' => 'تحقيقات شرطة تكشف أسراراً شخصية مظلمة.',
            'The Sopranos' => 'زعيم مافيا يواجه مشاكل نفسية وعائلية.',
            'The Wire' => 'شبكة معقدة من الجريمة والقانون في بالتيمور.',
            'Fargo' => 'قصص إجرامية مختلفة مليئة بالدهاء والموت.',
            'Ozark' => 'مخطط مالي ينتقل بعائلته إلى الريف هرباً من الجريمة.',
            'Peaky Blinders' => 'عصابة إجرامية بريطانية تشتهر بإخفاء شفرات في أجفانهم.',
            'Vikings' => 'مغامرات الفايكينج في عصور الغزوات التاريخية.',
            'Sons of Anarchy' => 'عصابة دراجات نارية تواجه صراعات داخلية وخارجية.',
            'The Walking Dead' => 'ناجون من نهاية العالم يقاتلون الزومبي.',
            'Prison Break' => 'مهندس يخطط هروب أخيه من السجن.',
            '24' => 'عميل سري يسابق الزمن لإيقاف هجمات إرهابية.',
            'Lost' => 'ناجون من تحطم طائرة في جزيرة مليئة بالأسرار.',
            'Dexter' => 'قاتل متسلسل يعمل محققاً في الشرطة.'
        ];

        $updatedShows = 0;
        foreach ($professionalDescriptions as $title => $description) {
            $show = Show::where('title', $title)->first();
            if ($show) {
                $show->update(['description' => $description]);
                $updatedShows++;
            }
        }

        // Clean up problematic images (generic or unrelated)
        $badImagePatterns = [
            'source.unsplash.com',
            'via.placeholder.com',
            'imgur.com/damascus-old-city.jpg',
            'imgur.com/jordanian-youth.jpg',
            'imgur.com/syrian-drama.jpg'
        ];

        $showsWithBadImages = Show::where(function($q) use ($badImagePatterns) {
            foreach ($badImagePatterns as $pattern) {
                $q->orWhere('thumbnail', 'LIKE', '%' . $pattern . '%')
                  ->orWhere('wallpaper', 'LIKE', '%' . $pattern . '%');
            }
        })->get();

        $this->command->info('Found ' . $showsWithBadImages->count() . ' shows with problematic images');

        // Replace with better generic images based on genre
        foreach ($showsWithBadImages as $show) {
            $genreImages = [
                'drama' => 'https://images.unsplash.com/photo-1489599672988-4b4c9b4b4c8b?w=500',
                'comedy' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500',
                'action' => 'https://images.unsplash.com/photo-1509347528160-9f6b01f42f5d?w=500',
                'thriller' => 'https://images.unsplash.com/photo-1489599672988-4b4c9b4b4c8b?w=500',
                'default' => 'https://images.unsplash.com/photo-1489599672988-4b4c9b4b4c8b?w=500'
            ];

            $genre = $this->detectGenre($show->title);
            $imageUrl = $genreImages[$genre] ?? $genreImages['default'];

            $show->update([
                'thumbnail' => $imageUrl,
                'wallpaper' => str_replace('w=500', 'w=1920', $imageUrl)
            ]);
        }

        // Clear video_url for shows that don't have real trailers
        $showsWithoutVideos = Show::whereNull('video_url')
                                 ->orWhere('video_url', '')
                                 ->orWhere('video_url', 'LIKE', '%placeholder%')
                                 ->get();

        foreach ($showsWithoutVideos as $show) {
            $show->update(['video_url' => null]);
        }

        $this->command->info('Cleanup completed!');
        $this->command->info('Updated ' . $updatedShows . ' show descriptions');
        $this->command->info('Removed ' . $blacklistedEpisodes->count() . ' blacklisted episodes');
        $this->command->info('Removed episodes with ' . count($duplicateIds) . ' duplicate YouTube IDs');
        $this->command->info('Fixed images for ' . $showsWithBadImages->count() . ' shows');
    }

    private function detectGenre($title)
    {
        $genreKeywords = [
            'drama' => ['حارة', 'خبز', 'سوري', 'تاريخي', 'اجتماعي', 'دراما'],
            'comedy' => ['غربال', 'كوميدي', 'The Office', 'Friends'],
            'action' => ['Breaking Bad', 'Game of Thrones', 'Vikings', 'The Witcher'],
            'thriller' => ['Stranger Things', 'Black Mirror', 'Dark', 'True Detective']
        ];

        foreach ($genreKeywords as $genre => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($title, $keyword) !== false) {
                    return $genre;
                }
            }
        }

        return 'default';
    }
}
