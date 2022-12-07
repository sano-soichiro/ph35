<?php
/**
 * PH35 サンプル2 PHP DB Access Src11/14
 * Chap4-1 エンティティクラスその1。
 *  *
 * @author Shinzo SAITO
 *  *
 * ファイル名=order.php
 * フォルダ=.ph35/phpdb/findone/
 */

/**
 * 注文情報エンティティ。
 * ordersテーブルに対応するエンティティクラス。
 */
class Order{
    /**
     * @var integer 注文ID。
     */
    private ?int $orderId = null;
        /**
     * @var string 注文日時。
     */
    private ?string $orderDate = "";
        /**
     * @var string 注文経路。
     */
    private ?string $orderMode = "";
        /**
     * @var integer 注文顧客ID。
     */
    private ?int $customerId = null;
        /**
     * @var integer 注文状況。
     */
    private ?int $orderStatus = null;
        /**
     * @var float 注文合計。
     */
    private ?float $orderTotal = null;
        /**
     * @var integer 注文担当者ID。
     */
    private ?int $salesRepId = null;
        /**
     * @var integer プロモーションコード番号。
     */
    private ?int $promotionId = null;

    // 以下アクセサメソッド。

    public function getorderId(): ?int{
        return $this->orderId;
    }
    public function setOrderId(?int $orderId): void{
        $this->orderId = $orderId;
    }
    public function getorderDate(): ?string{
        return $this->orderDate;
    }
    public function setOrderDate(?string $orderDate): void{
        $this->orderDate = $orderDate;
    }
    public function getorderMode(): ?string{
        return $this->orderMode;
    }
    public function setOrderMode(?string $orderMode): void{
        $this->orderMode = $orderMode;
    }
    public function getCustomerId(): ?int{
        return $this->customerId;
    }
    public function setCustomerId(?int $customerId): void{
        $this->customerId = $customerId;
    }
    public function getorderStatus(): ?int{
        return $this->orderStatus;
    }
    public function setOrderStatus(?int $orderStatus): void{
        $this->orderStatus = $orderStatus;
    }
    public function getorderTotal(): ?float{
        return $this->orderTotal;
    }
    public function setOrderTotal(?float $orderTotal): void{
        $this->orderTotal = $orderTotal;
    }
    public function getSalesRepId(): ?int{
        return $this->salesRepId;
    }
    public function setSalesRepId(?int $salesRepId): void{
        $this->salesRepId = $salesRepId;
    }
    public function getPromotionId(): ?int{
        return $this->promotionId;
    }
    public function setPromotionId(?int $promotionId): void{
        $this->promotionId = $promotionId;
    }
}
?>