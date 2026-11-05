<?php

namespace ComBank\OverdraftStrategy;

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use Override;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 12:27 PM
 */

class GoldOverdraft implements OverdraftInterface
{
    public function isGrantOverDraftFunds(float $draft): bool
    {
        return $this->getOverDraftFundsAmount() + $draft >= 0;
    }
    public function getOverDraftFundsAmount(): float
    {
        return 500.0;
    }
    public function getInterestRate(): int
    {
        return 10;
    }
}
