<?php
echo "<pre>";
class BankAccount
{

    private $bankAmount;

    public function getBankAmount()
    {
        return $this->bankAmount;
    }

    public function setBankAmount($bankAmount)
    {
        $this->bankAmount += $bankAmount;
        echo "На ваш счет внесено: {$bankAmount}" . PHP_EOL;
    }

    public function withdrawBankAmount($bankAmount) {
        if($this->bankAmount >= $bankAmount) {
            $this->bankAmount -= $bankAmount;
            echo "Операция разрешена. С вашего счета списано: {$bankAmount}" . PHP_EOL;
        } else {
            echo "На вашем счете не достаточно средств для снятия" . PHP_EOL;
        }
    }

    public function createBankAccount($bankAmount = 0) {
        for ($i = 0; $i < 16; $i++) {
            $arr[$i] = mt_rand(0,9);
        }
        $numberBankAccount = implode($arr);
        $numberBankAccount = preg_replace("#(\d{4})(\d{4})(\d{4})(\d{4})#","$1 $2 $3 $4",$numberBankAccount);
        $this->bankAmount = $bankAmount;
        echo "Счет создан. Номер счета: {$numberBankAccount}. Первоначальный взнос равен: {$this->getBankAmount()}" . PHP_EOL;
    }
    public function viewBalance() {
        echo "На вашем счете: {$this->getBankAmount()}" . PHP_EOL;
    }
    public function transferToAnotherAccount($transferAmount, $transferAccount) {
        if($this->bankAmount >= $transferAmount) {
            $this->withdrawBankAmount($transferAmount);
            $transferAccount->setBankAmount($transferAmount);
        } else {
            echo "На вашем счете не достаточно средств для перевода" . PHP_EOL;
        }
    }
}
/*
$bankAccount = new BankAccount();
$bankAccount->createBankAccount('5000');
$bankAccount->setBankAmount('5000');
$bankAccount->ViewBalance();
$bankAccount->withdrawBankAmount('2000');
$bankAccount->ViewBalance();
$bankAccount->withdrawBankAmount('9000');
$bankAccount->ViewBalance();
echo "<br>";
$transferAccount = new BankAccount();
$transferAccount->createBankAccount('3000');
$bankAccount->transferToAnotherAccount('2000', $transferAccount);
echo "<br>";
$bankAccount->ViewBalance();
echo "<br>";
$transferAccount->ViewBalance();
*/