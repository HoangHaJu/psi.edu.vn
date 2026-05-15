<?php

namespace App\Admin\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Admin\Http\Controllers\Controller;

class GamePsiController extends Controller
{
    /**
     * Trang mục lục chính của tất cả các Game
     */
    public function index()
    {
        return view('admin.auth.game_psi.index');
    }

    /**
     * Trang danh sách Unit của một Game cụ thể (VD: /game-psi/game-1)
     */
    public function showGame($game)
    {
        if (!in_array($game, [1, 2, 3])) {
            abort(404, "Game $game không hợp lệ.");
        }

        $viewPath = "admin.auth.game_psi.game{$game}.index";

        if (!view()->exists($viewPath)) {
            return redirect()->route('admin.game_psi.index')
                ->with('error', "Game $game đang được phát triển.");
        }

        return view($viewPath, ['gameNumber' => $game]);
    }

    /**
     * Trang chi tiết Unit cụ thể (VD: /game-psi/game-1/unit-3)
     */
    public function showUnit($game, $unit)
    {
        $viewPath = "admin.auth.game_psi.game{$game}.unit.unit{$unit}.index";

        if (!view()->exists($viewPath)) {
            abort(404, "Unit $unit của Game $game không tồn tại.");
        }

        return view($viewPath, [
            'gameNumber' => $game,
            'unit' => $unit,
        ]);
    }
}
