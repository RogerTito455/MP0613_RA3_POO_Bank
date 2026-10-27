<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Override;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function applyTransaction(BankAccountInterface $bankAccount): float
    {
        //Change to overdraft if false or true do the operation
        if (!$bankAccount->getOverDraft()->isGrantOverdraftFunds($bankAccount->getBalance()-$this->getAmount())) {
            throw new InvalidOverdraftFundsException("Insufficient balance to complete the withdrawal");
        }
        return $bankAccount->getBalance() - $this->amount;
    }
    #[Override]
    public function getTransactionInfo(): string
    {
        return "WITHDRAW_TRANSACTION";
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
