<?php
echo "<pre>";
include_once "DepositAccount.php";
class DepositInCurrency extends DepositAccount
{
    private $currency;
    private $rate;

    public function getRate() {
        return $this->rate;
    }

    public function createdepositInCurrencyAccount($bankAmount = 0, $percentage, $currency, $rate)
    {
        parent::createDepositAccount($bankAmount, $percentage);
        $this->currency = $currency;
        $this->rate = $rate;
        echo "Валюта депозита: {$this->currency}. Курс на момент подписания контракта: {$this->rate}" . PHP_EOL;
    }

    public function viewBalance()
    {
        $amountInUah = $this->getBankAmount() * $this->rate;
        echo "На вашем счете: {$this->getBankAmount()} {$this->currency}" . PHP_EOL;
        echo "Что по курсу {$this->rate} составит {$amountInUah} грн". PHP_EOL;
        }

    public function viewDepositIncome()
    {
        $incomeMonth = $this->incomeMonth() * $this->rate;
        $incomeYear = $this->incomeYear() * $this->rate;
        echo "Доход от депозита в {$this->currency}:" . PHP_EOL;
        parent::viewDepositIncome();
        echo "Доход от депозита в ГРН по курсу {$this->rate}:" . PHP_EOL;
        echo "Доход от депозита за месяц составит: {$incomeMonth}" . PHP_EOL;
        echo "Доход от депозита за год составит: {$incomeYear}" . PHP_EOL;
    }
}
/*
$depositInCurrency = new DepositInCurrency();
$depositInCurrency->createdepositInCurrencyAccount('1000', '30', 'EUR', '29');
$depositInCurrency->viewBalance();
$depositInCurrency->viewDepositIncome();
$depositInCurrency->withdrawBankAmount('1000');
$depositInCurrency->viewBalance();
$depositInCurrency->viewDepositIncome();
*/