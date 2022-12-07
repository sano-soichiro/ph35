<?php
class Department{
    /**
     * @var integer 部門ID
     */
    private ?int $departmentId = null;
        /**
     * @var string 部門名
     */
    private ?string $departmentName = "";
        /**
     * @var integer マネージャーID
     */
    private ?int $managerId = null;
        /**
     * @var integer 所在地ID
     */
    private ?int $locationId = null;

    //以下メソッド
    public function getDepartmentID(): ?int{
        return $this->departmentID;
    }
    public function setDepartmentID(?int $departmentID): void{
        $this->departmentID = $departmentID;
    }
    public function getDepartmentName(): ?string{
        return $this->departmentName;
    }
    public function setDepartmentName(?string $departmentName): void{
        $this->departmentName = $departmentName;
    }
    public function getManagerId(): ?string{
        return $this->managerId;
    }
    public function setManagerId(?string $managerId): void{
        $this->managerId = $managerId;
    }
    public function getLocationId(): ?int{
        return $this->locationId;
    }
    public function setLocationId(?int $locationId): void{
        $this->locationId = $locationId;
    }
}