<?php

namespace App\Http\Controllers;

use App\Exports\GamesExport;
use App\Exports\UsersExport;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'score' => 'required|integer',
            ]);

            $reward = $this->getReward($request->score);
            $wonPrize = $request->score >= 5 && $reward !== 'No prize';

            DB::beginTransaction();
            Game::create([
                'user_id' => Auth::id(),
                'score' => $request->score,
                'won_prize' => $wonPrize,
                'reward' => $reward,
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'won_prize' => $wonPrize,
                'reward' => $reward,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }

        return response()->json([
            'error' => 'Failed to end the game. Please try again.',
        ], 500);
    }

    private function getReward($score)
    {
        $random = rand(1, 100);
        if ($score >= 5) {
            if ($random <= 10) {
                return 'Iphone';
            } elseif ($random <= 40) {
                return 'Voucher';
            }
        }
        return 'No prize';
    }

    public function index()
    {
        $games = Game::orderBy('score', 'desc')->take(10)->get();
        return response()->json($games);
    }

    public function exportScores(Request $request)
    {
        return Excel::download(new GamesExport, 'games.xlsx');
    }

    public function exportUsers(Request $request)
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
