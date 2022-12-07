<?php

class CalcCircleAndBall {
    /**
	 * @var float 半径を表すプロパティ。
	 */
	private float $radius;
	
	/**
	 * @var float 円周率を表す定数プロパティ。
	 */
	const PI = 3.14;
	
	/**
	 * コンストラクタ。
	 * @param float radius 半径
	 */
	public function __construct(float $radius){
        $this->radius = $radius;
    }
	
	/**
	 * 半径を得るゲッタ。
	 * @return float 半径。
	 */
	public function getRadius(): float {
		return $this->radius;
	}
	
	/**
	 * 円周を得るメソッド。
	 * @return float 計算された円周。
	 */
	public function getCircle(): float {
		$circle = 2 * self::PI * $this->radius;
		return $circle;
	}
	
	/**
	 * 円の面積を得るメソッド。
	 * @return float 計算された円の面積。
	 */
	public function getArea(): float {
		$area = self::PI * $this->radius * $this->radius;
		return $area;
	}
	
	/**
	 * 球の表面積を得るメソッド。
	 * @return float 計算された球の表面積。
	 */
	public function getSurface(): float {
		$surface = 4 * self::PI * $this->radius * $this->radius;
		return $surface;
	}
	
	/**
	 * 球の体積を得るメソッド。
	 * @return float 計算された球の体積。
	 */
	public function getVolume(): float {
		$volume = 4 * self::PI * $this->radius * $this->radius * $this->radius / 3;
		return $volume;
	}
}