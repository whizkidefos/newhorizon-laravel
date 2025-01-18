protected function schedule(Schedule $schedule)
{
    $schedule->command('documents:check-expiring')->daily();
}