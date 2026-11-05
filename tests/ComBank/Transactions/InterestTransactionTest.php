<?php

use ComBank\Bank\BankAccount;
use PHPUnit\Framework\TestCase;
use ComBank\OverdraftStrategy\GoldOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\InterestTransaction;
use ComBank\Exceptions\ZeroAmountException;

class InterestTransactionTest extends TestCase
{
    /**
     * @test
     * */
    public function testInterestTransactionIsAppliedToAccount()
    {
        $bankAccount = new BankAccount(200.0, "test@example.com");
        $bankAccount->applyOverDraft(new GoldOverdraft());

        $bankAccount->transaction(new InterestTransaction());

        // GoldOverdraft: 10 % -> 200 + 20
        $this->assertEquals(220.0, $bankAccount->getBalance());
    }

    /**
     * @test
     * */
    public function testDepositStillRejectsZeroAmount()
    {
        $this->expectException(ZeroAmountException::class);
        new DepositTransaction(0);
    }
}
