<?php

$vegetables = [
    "d'aubergine",
    "de carotte"
];

$endPoint = "https://fr.wikibooks.org/w/api.php";
$params = [
    "action" => "query",
    "format" => "json",
    "list" => "categorymembers",
    "cmtitle" => "Catégorie:Recettes de cuisine à base de légume",
    "cmtype" => "subcat",
    "cmlimit" => "max",
];

$url = $endPoint . "?" . http_build_query( $params );

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec( $ch );
curl_close( $ch );

$result = json_decode( $output, true );

foreach( $result["query"]["categorymembers"] as $page ) {
    foreach ( $vegetables as $v) {
        if ( "Catégorie:Recettes de cuisine à base " . $v == $page["title"]) {
            //echo '<a href="https://fr.wikibooks.org/wiki/' . $page["title"] . '"> ' . $page["title"] . '  </a> <br>';
            $recipes = [
                "action" => "query",
                "format" => "json",
                "list" => "categorymembers",
                "cmtitle" => $page["title"],
                "cmtype" => "page",
                "cmlimit" => "max",
            ];

            $url = $endPoint . "?" . http_build_query( $recipes );

            $ch = curl_init( $url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $output = curl_exec( $ch );
            curl_close( $ch );

            $recipesJson = json_decode( $output, true );

            foreach ( $recipesJson["query"]["categorymembers"] as $recipe ) {
                echo '<a href="https://fr.wikibooks.org/wiki/' . $recipe["title"] . '"> ' . $recipe["title"] . '  </a> <br>';
            }
        }
    }
}