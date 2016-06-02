<?php
echo "<pre>";
include_once "BankAccount.php";
include_once "DepositAccount.php";
include_once "DepositInCurrency.php";
class BankUser
{
    private $userName;
    private $userSurname;
    private static $count;
    private static $data;

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getUserSurname()
    {
        return $this->userSurname;
    }

    public function setUserSurname($userSurname)
    {
        $this->userSurname = $userSurname;
    }

    public function addBankAccount($bankAmount = 0) {
        $bankAccount = new BankAccount();
        echo "{$this->getUserName()} {$this->getUserSurname()}" . PHP_EOL;
        $bankAccount->createBankAccount($bankAmount);
        self::$data[++self::$count] = $bankAccount;
        return $bankAccount;
        //print_r($this->data);
    }

    public function addDepositAccount($depositAmount = 0, $percentage) {
        $depositAccount = new DepositAccount();
        echo "{$this->getUserName()} {$this->getUserSurname()}" . PHP_EOL;
        $depositAccount->createDepositAccount($depositAmount, $percentage);
        self::$data[++self::$count] = $depositAccount;
        return $depositAccount;
        //print_r($this->data);
    }

    public function addDepositAccountInCurrency($depositAmount = 0, $percentage, $currency, $rate) {
        $depositAccountInCurrency = new DepositInCurrency();
        echo "{$this->getUserName()} {$this->getUserSurname()}" . PHP_EOL;
        $depositAccountInCurrency->createdepositInCurrencyAccount($depositAmount, $percentage, $currency, $rate);
        self::$data[++self::$count] = $depositAccountInCurrency;
        return $depositAccountInCurrency;
        //print_r($this->data);
    }

    public function printData() {
        print_r(self::$data);
    }

    public function deleteAccount($accountName)
    {
        if (isset($accountName)) {
            foreach (self::$data as $key => $value) {
                if ($value === $accountName) {
                   // print_r($value);
                    unset(self::$data[$key]);
                }
            }
            echo "Счет удален" . PHP_EOL;
            unset($accountName);
        } else {
            echo "Счет не существует" .PHP_EOL;
        }
    }

    public function viewBankBalance($accountName) {
        $i = 0;
        foreach (self::$data as $key => $value) {
            if($value === $accountName){
                $i += 1;
            }
        }
        if ($i == 0) {
            echo "Данного счета не существует" . PHP_EOL;
        } else {
            $accountName->viewBalance();
        }
    }

    public function viewTotalBalance() {
        $sum = 0;
        $i = 0;
        foreach (self::$data as $key => $value) {
            if (get_class($value) == 'DepositInCurrency') {
                $sum += $value->getBankAmount() * $value->getRate();
            } else{
                $sum += ($value->getBankAmount());
            }
            $i += 1;
        }
        echo "у Вас {$i} счета. Общий баланс равен {$sum}" . PHP_EOL;
    }

    public function incomeDeposit() {
        $incomeMonth = 0;
        foreach (self::$data as $key => $value) {
            if(get_class($value) !== 'BankAccount') {
                if (get_class($value) == 'DepositInCurrency') {
                    $incomeMonth += $value->incomeMonth() * $value->getRate();
            } elseif (get_class($value) == 'DepositAccount') {
                    $incomeMonth += $value->incomeMonth();
                }
            }
        }
       echo "Доход по депозитным счетам в месяц в ГРН: " . $incomeMonth . PHP_EOL;
    }

    public function transferToAnotherAccount($transferAmount, $accountName, $transferAccount) {
        foreach (self::$data as $key => $value) {
            if($value === $accountName) {
                if(get_class($value) == 'DepositInCurrency') {
                    if(get_class($transferAccount) == 'DepositInCurrency') {
                        $value->transferToAnotherAccount($transferAmount, $transferAccount);
                    } else {
                        $transferAccountBalance = $transferAccount->getBankAmount() / $value->getRate();
                        if($transferAccountBalance >= $transferAmount) {
                            $value->withdrawBankAmount($transferAmount);
                            $transferAccount->setBankAmount($transferAmount);
                        }
                    }
                }
                $value->transferToAnotherAccount($transferAmount, $transferAccount);
            }
        }
    }
}

$bankUser = new BankUser();
$bankUser->setUserName('Anna');
$bankUser->setUserSurname('Molibog');
$bankAccount = $bankUser->addBankAccount('3000');
$depositAccount = $bankUser->addDepositAccount('5000','14');
$depositAccountInCurrency = $bankUser->addDepositAccountInCurrency('1000','30','EUR','29');
//$bankUser->deleteAccount($depositAccountInCurrency);
//$bankUser->viewBankBalance($depositAccountInCurrency);
//$bankUser->printData();
$bankUser->viewTotalBalance();
$bankUser->incomeDeposit();
$bankUser2 = new BankUser();
$bankUser2->setUserName('Sergey');
$bankUser2->setUserSurname('Lysenko');
$bankAccount2 = $bankUser2->addBankAccount('8000');
$bankUser->transferToAnotherAccount('1000', $bankAccount, $bankAccount2);
$bankUser->viewBankBalance($bankAccount);
$bankUser->viewBankBalance($bankAccount2);
