<?php

namespace App\Helpers;

class PosPrinting
{
    public function centerAlign($string, $maxLength)
    {

        $stringLength   = strlen($string);
        $remainingLenth = $maxLength - $stringLength;

        $modResult      = fmod($remainingLenth, 2);

        $halfRemaining  = (int)($remainingLenth / 2);

        $output = '';
        for ($i = 0; $i < $halfRemaining; $i++) {
            $output = $output . ' ';
        }

        $output = $output . $string;

        for ($i = 0; $i < $halfRemaining; $i++) {
            $output = $output . ' ';
        }

        if ($modResult == 1) {
            $output = $output . ' ';
        }

        return $output;
    }

    public function justifyBetween($str1, $str2, $maxLength)
    {
        $totalLength = strlen($str1) + strlen($str2); // calculate the total length of both strings, plus a space between them

        // if the total length is less than or equal to the maximum length, return the two strings with a space between them
        if ($totalLength >= $maxLength) {
            return $str1 . " " . $str2;
        }

        $padLength = $maxLength - $totalLength; // calculate the number of spaces to pad between the two strings
        $space = str_repeat(" ", $padLength); // create a string of spaces to pad between the two strings

        return $str1 . $space . $str2; // return the two strings with padding between them
    }

    public function justifyLeft($str, $maxLength)
    {
        $strLength = strlen($str); // get the length of the input string

        if ($strLength >= $maxLength) { // if the input string is longer than or equal to the maximum length, return it unchanged
            return $str;
        }

        $padLength = $maxLength - $strLength; // calculate the number of spaces to pad before the string
        $space = str_repeat(" ", $padLength); // create a string of spaces with that length

        return $str . $space; // concatenate the padding string and the input string, and return the result
    }

    public function justifyRight($str, $maxLength)
    {
        $strLength = strlen($str); // get the length of the input string

        if ($strLength >= $maxLength) { // if the input string is longer than or equal to the maximum length, return it unchanged
            return $str;
        }

        $padLength = $maxLength - $strLength; // calculate the number of spaces to pad before the string
        $space = str_repeat(" ", $padLength); // create a string of spaces with that length

        return $space . $str; // concatenate the padding string and the input string, and return the result
    }

    public function FormatNumberLength($num, $length)
    {
        $r = "" + $num;
        while (strlen($r) < $length) {
            $r = "0" + $r;
        }
        return $r;
    }

    public function charDuplicator($char, $length)
    {
        $output = '';
        for ($i = 0; $i < $length; $i++) {
            $output = $output . $char;
        }
        return $output;
    }

    public function currencyFormat($sign, $amount)
    {
        return $sign . ' ' . number_format($amount, 2, '.', ',');
    }
}
