<?php
$file = "file.json";

if($_REQUEST['type'] == 'get'){
    $json = file_get_contents($file);

    echo $json;
}

if($_REQUEST['type'] == 'set'){

    //Данные которые пришли
    $postdata = json_decode(file_get_contents("php://input"), true);

    //Фомируем массив для записи
    $newItem = array(
        'id' => uniqid(),
        'content' => $postdata['text']
    );

    //Получаем текущие данные
    $arCurItems = json_decode(file_get_contents($file), true);

    $arCurItems[] = $newItem;
    
    file_put_contents($file, json_encode($arCurItems));

    $json = file_get_contents($file);

    echo $json;
}

if($_REQUEST['type'] == 'del'){

    //Данные которые пришли
    $postdata = json_decode(file_get_contents("php://input"), true);

    //Получаем текущие данные
    $arCurItems = json_decode(file_get_contents($file), true);

    $found_key = array_search($postdata['id'], array_column($arCurItems, 'id'));
    unset($arCurItems[$found_key]);

    $arCurItemsNew = array_values($arCurItems);
    
    file_put_contents($file, json_encode($arCurItemsNew));

    $json = file_get_contents($file);

    echo $json;
}
?>