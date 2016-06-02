<?php
echo "<pre>";
include_once "BankAccount.php";
class DepositAccount extends BankAccount
{
    private $percentage;
    const DAYS_IN_YEAR = 365;
    const DAYS_IN_MONTHS = 30;

    public function createDepositAccount($bankAmount = 0, $percentage)
    {
        parent::createBankAccount($bankAmount);
        $this->percentage = $percentage;
        echo "Процентная ставка годовых по депозиту равна: {$this->percentage}" . PHP_EOL;
    }

    public function getPercentage() {
        return $this->percentage;
    }

    public function incomeMonth() {
        $incomeMonth = ($this->getBankAmount() * $this->percentage * self::DAYS_IN_MONTHS) / (self::DAYS_IN_YEAR * 100);
        return round($incomeMonth,2);
    }

    public  function incomeYear() {
        $incomeYear = $this->incomeMonth() * 12;
        return round($incomeYear,2);
    }

    public function viewDepositIncome() {
        echo "Доход от депозита за месяц составит: {$this->incomeMonth()}" . PHP_EOL;
        echo "Доход от депозита за год составит: {$this->incomeYear()}" . PHP_EOL;
    }
}
echo "<br>";
/*
$depositAccount = new DepositAccount();
$depositAccount->createDepositAccount('5000','14');
$depositAccount->viewDepositIncome();
$depositAccount->withdrawBankAmount('2000');
$depositAccount->viewDepositIncome();
$depositAccount->setBankAmount('5000');
$depositAccount->viewBalance();
$depositAccount->viewDepositIncome();
*/