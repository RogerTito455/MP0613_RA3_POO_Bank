<?php

namespace ComBank\Bank\Contracts;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:26 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

interface BankAccountInterface
{
    const STATUS_OPEN = 'OPEN';
    const STATUS_CLOSED = 'CLOSED';
    //Función bank transacción interface
    public function transaction(BankTransactionInterface $bankTransactionInterface);
    //Función para validar si está abierto
    public function isOpen():bool;
    //Función reabrir account
    public function reopenAccount();
    //Función Close Account
    public function closeAccount();
    //Función getBalance
    public function getBalance();
    //Función Conseguir OverDraft accediendo a la interfaz de overdraft
    public function getOverDraft():OverdraftInterface;
    //Función applyOverDraft
    public function applyOverDraft(OverdraftInterface $overdraftInterface);
    //Función para setBalance
    public function setBalance(float $balance);




    

    
}
