<?php namespace VanTran\LunarCalendar\Sunlongitude;

use VanTran\LunarCalendar\Mjd\BaseMjd;

/**
 * Lớp cơ bản xử lý Kinh độ Mặt trời. Lớp này được thiết kế để truy xuất dữ liệu, không nên khởi tạo trực tiếp khi không
 * hiểu rõ các tham số đầu vào.
 * 
 * @author Văn Trần <caovan.info@gmail.com>
 * @package VanTran\LunarCalendar\Sunlongitude
 */
class BaseSunlongitude extends BaseMjd implements SunlongitudeInterface
{
    /**
     * @var float Số đo góc KDMT tương ứng với thời điểm nhập
     */
    protected $degrees;

    /**
     * Tạo đối tượng mới
     * 
     * @param float $jd Số ngày MJD
     * @param int $offset Bù UTC, tính bằng giây
     * @return void 
     */
    public function __construct(float $jd, int $offset = self::VN_OFFSET)
    {
        parent::__construct($jd, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function getDegrees(bool $withDecimal = false): int|float 
    { 
        if (!$this->degrees) {
            $this->degrees = $this->getDegreesFromJd($this->jd);
        }

        return ($withDecimal)
            ? $this->degrees
            : floor($this->degrees);
    }
    
    /**
     * Trả về góc KDMT tương ứng với số ngày MJD cho trước
     * 
     * @param float $jd 
     * @return float 
     */
    final protected function getDegreesFromJd(float $jd): float
    {
        $T = ($jd - 2451545.5) / 36525;
        $dr = M_PI / 180;
        $L = 280.460 + 36000.770 * $T;
        $G = 357.528 + 35999.050 * $T;
        $ec = 1.915 * sin($dr * $G) + 0.020 * sin($dr * 2 * $G);
        $lambda = $L + $ec ;
        
        return $L =  $lambda - 360 * floor($lambda / (360));
    }
}