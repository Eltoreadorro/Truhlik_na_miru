<?php
namespace App\Http\Controllers\Admin;

use App\Models\MailLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailLogController extends Controller
{
    public function index()
    {
        $logs = MailLog::latest()->paginate(20);
        return view('admin.mail-logs.index', compact('logs'));
    }

    public function destroy($id)
    {
        MailLog::findOrFail($id)->delete();
        return redirect()->route('admin.mail-logs.index')
            ->with('success', 'Log deleted!');
    }
}
