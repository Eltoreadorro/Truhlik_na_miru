<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MailLog;

class CleanMailLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Здесь указывается команда, которую нужно ввести в терминале.
     *
     * @var string
     */
    protected $signature = 'app:clean-mail-logs';

    /**
     * The console command description.
     *
     * Краткое описание назначения команды.
     *
     * @var string
     */
    protected $description = 'Deletes mail logs that are older than 3 months';

    /**
     * Execute the console command.
     *
     * Здесь выполняются основные действия команды.
     */
    public function handle(): void
    {
        // Определяем пороговую дату — все логи старше этой даты будут удалены.
        $thresholdDate = now()->subMonths(3);

        // Удаляем записи, где created_at меньше пороговой даты, и сохраняем количество удаленных строк.
        $deletedCount = MailLog::where('created_at', '<', $thresholdDate)->delete();

        // Выводим информацию с количеством удаленных логов и датой порога
        $this->info("Deleted {$deletedCount} mail logs older than {$thresholdDate->toDateString()}.");
    }
}
