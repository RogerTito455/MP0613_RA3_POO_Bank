<?php

namespace ComBank\Transactions;


use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Exception;
use Override;

class TransferTransaction extends BaseTransaction implements BankTransactionInterface
{
    private BankAccountInterface $destinationAccount;
    public function __construct(float $amount, BankAccountInterface $destinationAccount)
    {
        parent::__construct($amount);
        $this->destinationAccount = $destinationAccount;
    }
    public function getDestinationAccount(): BankAccountInterface
    {
        return $this->destinationAccount;
    }
    public function setDestinationAccount(BankAccountInterface $destinationAccount)
    {
        $this->destinationAccount = $destinationAccount;
    }

    public function applyTransaction(BankAccountInterface $bankAccount): float
    {
        if (!$bankAccount->getOverDraft()->isGrantOverdraftFunds($bankAccount->getBalance() - $this->getAmount())) {
            throw new FailedTransactionException("Transfer rejected when the source account has insufficient available funds    ");
        }
        $this->getDestinationAccount()->setBalance($this->getDestinationAccount()->getBalance() + $this->getAmount());
        return $bankAccount->getBalance() - $this->getAmount();
    }
    public function getTransactionInfo(): string
    {
        return "TRANSACTION_TRANSACTION";
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
