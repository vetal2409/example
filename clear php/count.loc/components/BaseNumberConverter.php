<?php
namespace components;

class BaseNumberConverter
{
    public $l1, $l2, $l3, $l4, $l5, $l6;

    public function untilHundred($num, $type = 0)
    {
        if ($num >= 20) {
            $k1 = $num % 10;
            $result = $this->l3[intval($num / 10)] . ($k1 ? ' ' . $this->l1[$type][$k1] : '');
        } elseif ($num > 9) {
            $result = $this->l2[$num - 10];
        } else {
            $result = $this->l1[$type][$num];
        }
        return $result;
    }

    public function untilThousand($num, $type = 0)
    {
        if ($num < 100) {
            $result = $this->untilHundred($num, $type);
        } else {
            $result = $this->l4[intval($num / 100)] . ' ' . $this->untilHundred($num % 100, $type);
        }
        return $result;
    }

    public function untilMillion($num)
    {
        if ($num < 1000) {
            $result = $this->untilThousand($num);
        } else {
            $numThousand = intval($num / 1000);
            $result = $this->untilThousand($numThousand, 1) . ' ' . $this->l5[$numThousand % 10] . ' ' . $this->untilThousand($num % 1000);
        }
        return $result;
    }

    public function untilBillion($num)
    {
        if ($num < 1000000) {
            $result = $this->untilMillion($num);
        } else {
            $numThousand = intval($num / 1000000);
            $result = $this->untilThousand($numThousand) . ' ' . $this->l6[$numThousand % 10] . ' ' . $this->untilMillion($num % 1000000);
        }
        return $result;
    }
} 