<?php
require('functions.inc.php');


$cocktails = makeRequest('https://www.thecocktaildb.com/api/json/v1/1/search.php?s=gin');

print '<pre>';
print_r($cocktails);
exit;

print '<table>';

foreach ($cocktails->drinks as $drink) {

    print '<tr>';
    print '<td>' . $drink->idDrink . '</td>';
    print '<td>' . $drink->strDrink . '</td>';
    print '<td>' . $drink->strCategory . '</td>';
    print '<td>' . $drink->strAlcoholic . '</td>';
    print '</tr>';
}

print '</table>';
