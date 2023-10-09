<?php

namespace App\Console\Commands;

use App\Enums\DiscountBoxStatusEnum;
use App\Enums\StatusEnum;
use App\Models\DiscountBox;
use Illuminate\Console\Command;

class CheckDiscountBoxExpirationDateCommand extends Command
{
    protected $signature = 'app:check-discount-box-expiration-date-command';

    protected $description = 'Check if discount box expiration date is passed and update discount box status to concluded.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Check if discount box expiration date is passed and update discount box status to concluded.');

        DiscountBox::query()
            ->where('status', StatusEnum::IN_PROGRESS)
            ->where('expires_at', '<=', now())
            ->update(['status' => StatusEnum::CONCLUDED]);

        return self::SUCCESS;

    }
}
