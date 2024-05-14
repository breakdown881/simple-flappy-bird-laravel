<?php

namespace App\Exports;

use App\Models\Game;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GamesExport implements FromView
{
    public function view(): View
    {
        return view('exports.games', [
            'games' => Game::all()
        ]);
    }
}
