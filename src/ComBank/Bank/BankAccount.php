<?php

namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Override;
use PhpParser\Node\Expr\FuncCall;

class BankAccount implements BankAccountInterface
{
    use AmountValidationTrait;

    private float $balance;
    private bool $status;
    private OverdraftInterface $overdraft;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
        $this->status = true;
        $this->overdraft = new NoOverdraft;
    }

    //Declaramos las variables para utilizar ahora overdraft

    public function setOverdraft($overdraft)
    {
        $this->overdraft = $overdraft;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /*
    =====================================================   
    Funciones de la interfaz
    =====================================================
    */
    public function transaction(BankTransactionInterface $bankTransaction): void
    {
        if (!$this->getStatus()) {
            throw new BankAccountException("Cannot perform on a closed account");
        }
        //Aplicar transaccion applyTransaction de la clase deposit
        $this->validateAmount($bankTransaction->getAmount());

        try {
            $newBalance = $bankTransaction->applyTransaction($this);
        } catch (InvalidOverdraftFundsException $e) {
            throw new FailedTransactionException("Insufficient balance to complete the transaction", 0, null);
        }
        //Actualizar el balance del objeto que tenemos el nuevo balance
        $this->setBalance($newBalance);
    }

    #[Override]
    public function isOpen(): bool
    {
        if ($this->status) {
            return true;
        }
        return false;
    }

    // Reopen Account
    public function reopenAccount()
    {
        if ($this->status) {
            throw new BankAccountException('Account is already open');
        }
        $this->setStatus(true);
    }
    public function closeAccount()
    {
        if (!$this->status) {
            throw new BankAccountException('Account is already closed');
        }
        $this->setStatus(false);
    }
    #[Override]
    public function getBalance()
    {
        return $this->balance;
    }
    #[Override]
    public function getOverdraft(): OverdraftInterface
    {
        return $this->overdraft;
    }
    #[Override]
    public function applyOverDraft(OverdraftInterface $overdraft)
    {
        $this->overdraft = $overdraft;
    }
    #[Override]
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }
}
