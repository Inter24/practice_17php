<?php

function getPartsFromFullname($fio) {

    $fioparts = explode(' ', $fio);
    
    return array(
        ['surname' => $fioparts[0]],
        ['name' => $fioparts[1]],
        ['patronomyc' => $fioparts[2]],
    );

}

function getFullnameFromParts($surmane, $name, $patronomyc) {

    return $surmane.' '.$name.' '.$patronomyc;

}

function getShortName($fio) {

    $fio_arr = getPartsFromFullname($fio);
    $surname = $fio_arr[0]['surname'];
    $name = $fio_arr[1]['name'];

    $short = $name.' '.mb_substr($surname, 0, 1).'.';    

    return $short;
}

function getGenderFromName($fio) {

    if (!$fio) {
        return false;
    }

    $fio_arr = getPartsFromFullname($fio);
    $surname = $fio_arr[0]['surname'];
    $name = $fio_arr[1]['name'];
    $patronomyc = $fio_arr[2]['patronomyc'];

    $gender = 0;

    //check female

    if (mb_substr($patronomyc, -3) == 'вна') {
        $gender -= 1;
    }
    if (mb_substr($name, -1) == 'а') {
        $gender -= 1;
    }
    if (mb_substr($surname, -2) == 'ва') {
        $gender -= 1;
    }  

    //check male

    if (mb_substr($patronomyc, -2) == 'ич') {
        $gender += 1;
    }
    if (mb_substr($name, -1) == 'й' || mb_substr($name, -1) == 'н' ) {
        $gender += 1;
    }
    if (mb_substr($surname, -1) == 'в') {
        $gender += 1;
    }  

    
    if ($gender > 0) {
        return 'мужской пол';
    } elseif ($gender < 0 ) {
        return 'женский пол';
    } else {
        return 'неопределенный пол';
    }

}


function getGenderDescription ($fiolist) {

    if (!is_array($fiolist)) {
        return false;
    }

    $count = 0;
    $count_man = 0;
    $count_woman = 0;
    $count_undefined = 0;
    $values_fio = [];

    foreach ($fiolist as $key => $values) {    

        array_push($values_fio, $values["fullname"]);

    }

    foreach ($values_fio as $key => $value) {
         
        if (getGenderFromName($value)=='мужской пол') {
            $count_man++;
        };
        if (getGenderFromName($value)=='женский пол') {
            $count_woman++;
        };
        if (getGenderFromName($value)=='неопределенный пол') {
            $count_undefined++;
        };

        $count++;
    }
    
    $totalman = round($count_man * 100 / $count);
    $totalwoman = round($count_woman * 100 / $count);
    $totalundefined = round($count_undefined * 100 / $count);
    
    echo <<<HEREDOCLETTER
    Гендерный состав аудитории:
    ---------------------------
    Мужчины - $totalman%
    Женщины - $totalwoman%
    Не удалось определить - $totalundefined%
    HEREDOCLETTER;

}

function getPerfectPartner($surmane, $name, $patronomyc, $fiolist) {  

    $values_fio = [];
    
    $fio = getFullnameFromParts(mb_convert_case(mb_strtolower($surmane), MB_CASE_TITLE, "UTF-8"), mb_convert_case(mb_strtolower($name), MB_CASE_TITLE, "UTF-8"), mb_convert_case(mb_strtolower($patronomyc), MB_CASE_TITLE, "UTF-8"));


    foreach ($fiolist as $key => $values) {    
        array_push($values_fio, $values["fullname"]);
    }

    foreach ($values_fio as $key => $value) {
        $rand_keys = array_rand($values_fio);
        $random_fio = $values_fio[$rand_keys];
        $randomvalue = round(rand(5000, 10000)/100, 2);
        
            if (getGenderFromName($random_fio) <> getGenderFromName($fio)) {
                $shortmale = getShortName($fio);
                $shortfemale = getShortName($random_fio);

                echo <<<HEREDOCLETTER
                $shortmale + $shortfemale = 
                ♡ Идеально на $randomvalue% ♡
                HEREDOCLETTER;

                break;
            }

    }

}


?>