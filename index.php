<?php
/* Клавиша shift*/

// Для тестов
$textShift = "много их в Петербурге,молоденьких дур,сегодня в атласе да бархате,а завтра , поглядишь ,  метут улицу вместе с голью кабацкою... в самом деле ,что было бы с нами ,если бы вместо общеудобного правила:чин чина почитай , ввелось в употребление другое,например:ум ума почитай?какие возникли бы споры!";
//$text = 'roses are red,and violets are blue.whatever you do i\'ll keep it for you.';
//$text = 'привет.есть 2 функции,preg_split и explode ,не понимаю,в чем между ними разница.';

/* Делает первую букву в строке заглавной */
function makeFirstLetterUppercase($text) {
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}

/* Исправляет текст */
function fixText($text) {
    $regExp = [
        "expSplit" => "/(?<=[.!?])\s*/u",
        "expReplace" => "/\s*([,.!?;:]+)\s*/u",
        "replacement" => "$1 "
    ];
    $arrayString = preg_split($regExp["expSplit"], $text, -1, PREG_SPLIT_NO_EMPTY);
    $resultString = "";

    foreach ($arrayString as $string) {
        $resultString .= makeFirstLetterUppercase($string);
    }

    return preg_replace($regExp["expReplace"], $regExp["replacement"], $resultString);
}

$result = fixText($textShift);
echo "$result\n";

/* Yoda Speak */

//$text = "Кажется, нас обнаружили! Надо срочно уходить отсюда, пока не поздно. Бежим же скорее!";
// Другие варианты для тестов
//$text = "Ну, прости меня! Не хотела я тебе зла сделать; да в себе не вольна была. Что говорила, что делала, себя не помнила.";
$text = "Идет гражданская война?? Космические корабли повстанцев, наносящие удар с тайной базы, одержали первую победу, в схватке со зловещей Галактической Империей!";

function makeYodaStyleText($text) {
    $regExp = [
        "expSplit" => "/([.!?;]+)\K\s*/",
        "expUselessSymbol" => "/[:,-]/",
        "expReplace" => "/([^.!?;]+)([.!?;]+)(.+)/",
        "replacement" => "$1$3$2"
    ];
    $text = mb_strtolower(preg_replace($regExp["expUselessSymbol"], "", $text));
    $strings = preg_split($regExp["expSplit"], $text, -1, PREG_SPLIT_NO_EMPTY);
    $reverseStrings = [];

    foreach ($strings as $string) {
        $reverseWords = array_reverse(explode(" ", $string));
        $reverseStrings[] = makeFirstLetterUppercase(implode(" ", $reverseWords));
    }

    return implode(" ", preg_replace($regExp["expReplace"], $regExp["replacement"], $reverseStrings));
}

$yodaText = makeYodaStyleText($text);
echo "Йода говорит: {$yodaText}\n";