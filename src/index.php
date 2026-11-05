<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\GoldOverdraft;
use ComBank\Transactions\InterestTransaction;
use ComBank\Transactions\TransferTransaction;

require_once 'bootstrap.php';

//---[Bank account 1]---/
// create a new account1 with balance 400
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    $bankAccount1 = new BankAccount(400.0, "crtito@gmail.com");
    pl($bankAccount1->getEmail());
    // show balance account
    pl('Balance account: ' . $bankAccount1->getBalance());
    // close account
    $bankAccount1->closeAccount();
    pl('My account is now closed.');
    // reopen account
    $bankAccount1->reopenAccount();
    pl('My account is now reopened.');
    // deposit +150
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150.0));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());
    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25));
    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());
    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600.0));
    //Closing Account

} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());
$bankAccount1->closeAccount();
pl('My account is now closed.');




//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    $bankAccount2 = new BankAccount(200.0, "crtito@gmail.com");
    $bankAccount2->applyOverDraft(new SilverOverdraft());
    pl($bankAccount2->getEmail());

    // show balance account
    pl('Balance account: ' . $bankAccount2->getBalance());

    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100.0));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction withdrawal (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300.0));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction withdrawal (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50.0));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120.0));
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl('Error: ' . $e->getMessage());
    exit;
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20.0));
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

try {
    $bankAccount2->closeAccount();
    pl('My account is now closed.');
    $bankAccount2->closeAccount();
} catch (BankAccountException $e) {
    pl($e->getMessage());
}


//Testing
//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    $bankAccount3 = new BankAccount(200, "crtito@gmail.com");
    $bankAccount3->applyOverDraft(new GoldOverdraft());
    pl($bankAccount3->getEmail());
    $bankAccount3->transaction(new InterestTransaction());
    // show balance account
    pl('Balance account: ' . $bankAccount3->getBalance() + $bankAccount3->getOverdraft()->getOverDraftFundsAmount());

    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new DepositTransaction(100.0));
    pl('My new balance after deposit (+100) : ' . $bankAccount3->getBalance());

    // withdrawal -300
    pl('Doing transaction withdrawal (-300) with current balance ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new WithdrawTransaction(300.0));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount3->getBalance());

    // withdrawal -50
    pl('Doing transaction withdrawal (-50) with current balance ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new WithdrawTransaction(50.0));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount3->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new WithdrawTransaction(120.0));
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl('Error: ' . $e->getMessage());
    exit;
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount3->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new WithdrawTransaction(20.0));
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount3->getBalance());

try {
    $bankAccount3->closeAccount();
    pl('My account is now closed.');
    $bankAccount3->closeAccount();
} catch (BankAccountException $e) {
    pl($e->getMessage());
}

//Account 1 & 2 Testing exam final
//Testing
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    //Sample 1
    $bankAccount0 = new BankAccount(500, "crtito@gmail.com");
    $bankAccount01 = new BankAccount(200, "crtito1@gmail.com");

    //OverDraft 500
    $bankAccount0->applyOverDraft(new GoldOverdraft());
    pl($bankAccount0->getEmail());
    // show balance account

    pl('Source Account Balance: €' . $bankAccount0->getBalance());
    pl('Destination Account Balance: €' . $bankAccount01->getBalance());
    //Transaction
    $bankAccount0->transaction(new TransferTransaction(100, $bankAccount01));
    pl('Transfer Amount: €100.00');
    //After Transaction
    pl('Source Balance After Transaction: €' . $bankAccount0->getBalance());
    pl('Destination Balance After Transaction: €' . $bankAccount01->getBalance());

} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl('Error: ' . $e->getMessage());
    exit;
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}


//Testing
//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    $bankAccount6 = new BankAccount(50, "crtito@gmail.com");
    $bankAccount7 = new BankAccount(200, "crtito@gmail.com");
    pl('Source Account Balance: €' . $bankAccount6->getBalance());
    pl('Destination Account Balance: €' . $bankAccount7->getBalance());
    //Transaction
    $bankAccount6->transaction(new TransferTransaction(100, $bankAccount7));
    pl('Transfer Amount: €100.00');
    //After Transaction
    pl('Source Balance After Transaction: €' . $bankAccount6->getBalance());
    pl('Destination Balance After Transaction: €' . $bankAccount7->getBalance());
   
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl('Error: ' . $e->getMessage());
    exit;
} catch (FailedTransactionException $e) {
    pl($e->getMessage());
}

