<?php
namespace components;


require_once 'BaseNumberConverter.php';

class NumberConverter extends BaseNumberConverter
{
    function __construct($lang = 'ru')
    {
        if ($lang === 'ru') {
            $this->l1 = array(
                array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
                array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            );
            $this->l2 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
            $this->l3 = array('', '', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
            $this->l4 = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
            $this->l5 = array('тысяч', 'тысяча', 'тысячи', 'тысячи', 'тысячи', 'тысяч', 'тысяч', 'тысяч', 'тысяч', 'тысяч');
            $this->l6 = array('миллионов', 'миллион', 'миллиона', 'миллиона', 'миллиона', 'миллионов', 'миллионов', 'миллионов', 'миллионов', 'миллионов');
        } elseif ($lang === 'ua') {
            $this->l1 = array(
                array('', 'один', 'два', 'три', 'чотири', 'п\'ять', 'шість', 'сім', 'вісім', 'дев\'ять'),
                array('', 'одна', 'дві', 'три', 'чотири', 'п\'ять', 'шість', 'сім', 'вісім', 'дев\'ять'),
            );
            $this->l2 = array('десять', 'одинадцять', 'дванадцять', 'тринадцять', 'чотирнадцять', 'п\'ятнадцять', 'шістнадцять', 'сімнадцять', 'вісімнадцять', 'дев\'ятнадцять');
            $this->l3 = array('', '', 'двадцять', 'тридцять', 'сорок', 'п\'ятдесят', 'шістдесят', 'сімдесят', 'вісімдесят', 'дев\'яносто');
            $this->l4 = array('', 'сто', 'двісті', 'триста', 'чотириста', 'п\'ятсот', 'шістсот', 'сімсот', 'вісімсот', 'дев\'ятсот');
            $this->l5 = array('тисяч', 'тисяча', 'тисячі', 'тисячі', 'тисячі', 'тисяч', 'тисяч', 'тисяч', 'тисяч', 'тисяч');
            $this->l6 = array('мільйонів', 'мільйон', 'мільйона', 'мільйона', 'мільйона', 'мільйонів', 'мільйонів', 'мільйонів', 'мільйонів', 'мільйонів');

        } elseif ($lang === 'en') {
            $this->l1 = array(
                array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'),
                array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'),
            );
            $this->l2 = array('ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
            $this->l3 = array('', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');
            $this->l4 = array('', 'one hundred', 'two hundred', 'three hundred', 'four hundred', 'five hundred', 'six hundred', 'seven hundred', 'eight hundred', 'nine hundred');
            $this->l5 = array('thousand', 'thousand', 'thousand', 'thousand', 'thousand', 'thousand', 'thousand', 'thousand', 'thousand', 'thousand');
            $this->l6 = array('million', 'million', 'million', 'million', 'million', 'million', 'million', 'million', 'million', 'million');
        }

    }
} 