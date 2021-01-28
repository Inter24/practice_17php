<?php

include('persons_array.php');
include('func_fio.php');

//var_dump($example_persons_array);
//echo("<br><br><br>");

print_r(getPartsFromFullname($example_persons_array[2]['fullname']));
echo("<br><br><br>");
echo(getFullnameFromParts('иванов', 'иван', 'иванович'));
echo("<br><br><br>");
echo (getShortName($example_persons_array[2]['fullname']));
echo("<br><br><br>");
echo (getGenderFromName($example_persons_array[9]['fullname']));
echo("<br><br><br>");
echo (getGenderDescription($example_persons_array));
echo("<br><br><br>");
echo(getPerfectPartner('иВАнов', 'ивАн', 'иВанович', $example_persons_array));


?>