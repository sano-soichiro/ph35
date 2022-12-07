<?php
class Salary{
    /**
     * @var integer 顧客ID
     */
    private ?int $employeeId = null;
        /**
     * @var string 顧客名
     */
    private ?string $firstName = "";
        /**
     * @var string 顧客姓
     */
    private ?string $lastName = "";
        /**
     * @var integer 給料
     */
    private ?int $salary = null;

    //以下メソッド
    public function getEmployeeId(): ?int{
        return $this->employeeId;
    }
    public function setEmployeeId(?int $employeeId): void{
        $this->employeeId = $employeeId;
    }
    public function getFirstName(): ?string{
        return $this->firstName;
    }
    public function setFirstName(?string $firstName): void{
        $this->firstName = $firstName;
    }
    public function getLastName(): ?string{
        return $this->lastName;
    }
    public function setLastName(?string $lastName): void{
        $this->lastName = $lastName;
    }
    public function getSalary(): ?int{
        return $this->salary;
    }
    public function setSalary(?int $salary): void{
        $this->salary = $salary;
    }
}