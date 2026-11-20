<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // ユーザーをデータベースに正常に登録できるかのテスト
    public function test_user_can_be_created()
    {
        // ユーザーをデータベースに登録
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 登録したユーザーのレコードがデータベースに存在するかの確認
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com', 
        ]);
    }

    // 重複したメールアドレスを登録しようとすると正常に例外が発生するかのテスト
    public function test_email_must_be_unique()
    {
        // ユーザー1人目をデータベースに登録（まだメールアドレスの重複なし）
        User::factory()->create([
            'name' => 'Test User1',
            'email' => 'test@example.com',
        ]);

        // メールアドレスの重複により例外が発生することを期待
        $this->expectException(\Illuminate\Database\QueryException::class);

        // ユーザー2人目をデータベースに登録（ここでメールアドレスの重複が発生）
        User::factory()->create([
            'name' => 'Test User2',
            'email' => 'test@example.com',
        ]);
    }
}
