<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;

class TestPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->testGetMEthod();
        $this->testChunkMethod();
    }

    private function testGetMethod()
    {
        // メモリ使用量の初期値を取得
        $initialMemory = memory_get_usage();

        // 処理開始時間を取得
        $startTime = microtime(true);

        // getメソッドでcityを取得
        $cities = City::get();
        
        foreach ($cities as $user) {
            // ダミー処理
            $uppercaseName = strtoupper($user->name);
            $nameLength = strlen($uppercaseName);
        }

        $endTime = microtime(true);

        // メモリ使用量の差分を計算
        $memoryUsage = memory_get_usage() - $initialMemory;

        // 処理時間を計算
        $executionTime = $endTime - $startTime;

        $this->info("getメソッドのメモリ使用量：" . $memoryUsage . "bytes");
        $this->info("getメソッドの処理時間: " . $executionTime . " seconds");
    }

    private function testChunkMethod()
    {
        // メモリ使用量の初期値を取得
        $initialMemory = memory_get_usage();

        // 処理開始時間を取得
        $startTime = microtime(true);

        // chunkメソッドでcityを分割して取得
        City::chunk(1000, function($cities) {
            foreach ($cities as $city) {
                // ダミー処理
                $uppercaseName = strtoupper($city->name);
                $nameLength = strlen($uppercaseName);
            }
        });

        $endTime = microtime(true);

        // メモリ使用量の差分を計算
        $memoryUsage = memory_get_usage() - $initialMemory;

        // 処理時間を計算
        $executionTime = $endTime - $startTime;

        $this->info("chunkメソッドのメモリ使用量: " . $memoryUsage . " bytes");
        $this->info("chunkメソッドの処理時間: " . $executionTime . " seconds");
    }
}
