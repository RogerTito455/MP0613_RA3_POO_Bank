<?php

namespace ComBank\Transactions;


use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Override;

class InterestTransaction extends BaseTransaction implements BankTransactionInterface
{

    public function __construct($amount = 0)
    {
        $this->amount = $amount;
    }
    public function applyTransaction(BankAccountInterface $bankAccount): float
    {
        return ($bankAccount->getBalance() + ($bankAccount->getBalance() * $bankAccount->getOverDraft()->getInterestRate() / 100));
    }
    public function getTransactionInfo(): string
    {
        return "INTEREST_TRANSACTION";
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
