<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'settings' => [
                'shop_name' => config('app.name'),
                // Добавьте другие настройки
            ]
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            // Добавьте другие правила валидации
        ]);

        // Здесь логика сохранения настроек
        // Например, в .env или в базе данных

        return redirect()->back()
            ->with('success', 'Nastavení bylo úspěšně uloženo');
    }
}
