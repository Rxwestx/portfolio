<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoalController extends Controller
{
    // 目標設定ページの表示
    public function create()
    {
        return view('goals.create');
    }

    // 目標の保存
    public function store(Request $request)
    {
        $request->validate([
            'goal' => 'required|string',
            'goal_deadline' => 'required|date',
            'target_hours' => 'required|integer|min:1',
        ], [
            // エラーメッセージ（日本語）
            'goal.required' => '目標を入力してください',
            'goal_deadline.required' => '期限を入力してください',
            'target_hours.required' => 'トータル時間を入力してください',
        ]);

        \App\Models\Goal::create([
            'user_id' => auth()->id(),
            'goal' => $request->goal,
            'goal_deadline' => $request->goal_deadline,
            'target_hours' => $request->target_hours,
        ]);

        return redirect()->route('dashboard')->with('success', '目標を設定しました！');
    }
}
