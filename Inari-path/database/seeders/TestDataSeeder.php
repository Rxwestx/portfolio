<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Goal;
use App\Models\TimeLogs;
use App\Models\Character;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rankMessages = $this->rankMessages();

        $accounts = [
            [
                'name' => '山田 花子',
                'email' => 'example@example.jp',
                'goal' => '読書や学習を頑張りたい',
                'target_hours' => 100,
                'deadline_days' => 90,
                'durations' => [320, 360, 300, 280, 340, 310, 290],
            ],
            [
                'name' => '佐藤 太一',
                'email' => 'example@example.com',
                'goal' => 'プログラミングを頑張りたい',
                'target_hours' => 140,
                'deadline_days' => 120,
                'durations' => [260, 280, 300, 240, 220, 260, 240],
            ],
            [
                'name' => '高橋 さくら',
                'email' => 'test@test.app',
                'goal' => '資格学習を継続したい',
                'target_hours' => 180,
                'deadline_days' => 150,
                'durations' => [220, 240, 260, 200, 180, 210, 230],
            ],
            [
                'name' => '伊藤 健',
                'email' => 'learning@example.app',
                'goal' => 'プログラミングを頑張りたい',
                'target_hours' => 260,
                'deadline_days' => 180,
                'durations' => [280, 300, 260, 240, 320, 300, 280],
            ],
            [
                'name' => '中村 美咲',
                'email' => 'study@test.jp',
                'goal' => '読書や学習を頑張りたい',
                'target_hours' => 500,
                'deadline_days' => 210,
                'durations' => [520, 480, 500, 460, 510, 490, 500],
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew(['email' => $account['email']]);
            $user->forceFill([
                'name' => $account['name'],
                'email_verified_at' => now(),
                // User model の hashed cast に任せてハッシュ化
                'password' => 'password',
            ])->save();

            $goal = Goal::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'goal' => $account['goal'],
                    'goal_deadline' => now()->addDays($account['deadline_days'])->toDateString(),
                    'target_hours' => $account['target_hours'],
                ]
            );

            TimeLogs::where('goal_id', $goal->id)->delete();

            // 最新書き込みを4日前に固定して「3日以上未書き込み」状態を作る
            $daysAgo = [32, 24, 18, 14, 10, 7, 4];
            foreach ($daysAgo as $index => $day) {
                TimeLogs::create([
                    'goal_id' => $goal->id,
                    'logged_at' => now()->subDays($day)->toDateString(),
                    'duration_minutes' => $account['durations'][$index],
                ]);
            }

            $totalMinutes = array_sum($account['durations']);
            $targetMinutes = $account['target_hours'] * 60;
            $percent = $targetMinutes > 0
                ? min(100, (int) floor(($totalMinutes / $targetMinutes) * 100))
                : 0;
            $rank = min(10, intdiv($percent, 10));

            Character::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'exp' => $totalMinutes,
                    'rank' => $rank,
                    'rank_name' => Character::getRankNameFromLevel($rank),
                    'rank_message' => $rankMessages[$rank] ?? Character::getRankNameFromLevel($rank),
                    'last_rank_down_at' => null,
                ]
            );
        }

        $this->command->info('Dummy data seeded: users/goals/time logs/characters (5 accounts).');
        $this->command->info('Login password for all seeded users: password');
        $this->command->info('Latest time log for every user is set to 4 days ago.');
    }

    private function rankMessages(): array
    {
        return [
            0 => 'まだ何も始まっていない。けれど、この場所に立ったという事実が最初の一歩だ。',
            1 => '歩き出した狐。小さな一歩が、やがて大きな変化を生む。',
            2 => '学びを覚えた狐。知識の風が、少しずつ視界を広げていく。',
            3 => '習慣を手にした狐。継続の力が、未来を静かに変えていく。',
            4 => '自信を持ち始めた狐。挑戦する姿勢が、次の成長を呼び込む。',
            5 => '分岐点に立つ狐。学びが「やること」から「生き方」へ変わり始めた。',
            6 => '考える狐。深い思索が、知恵をさらに磨いていく。',
            7 => '自立した狐。自分の道を切り開き、他者にも光を届ける。',
            8 => '覚悟を宿す狐。簡単ではない道を選び、それでも進み続ける。',
            9 => '妖狐の境界に達した狐。限界を越え、さらに高みへ挑む。',
            10 => '覚醒せし妖狐。学びの旅は終わらない。新たな伝説の始まりだ。',
        ];
    }
}
