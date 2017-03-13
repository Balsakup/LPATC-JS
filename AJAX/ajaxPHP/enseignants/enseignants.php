<?php
header('Access-Control-Allow-Origin: *');
// le script extrait les infos demandées à partir du fichier XML data/enseignants.xml

function debug($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

if (array_key_exists('id', $_GET)) {
    $id  = $_GET['id'];
    $xml = simplexml_load_file('data/enseignants.xml');

    foreach ($xml as $enseignant) {
        $enseignantId = current($enseignant->attributes($xml->getNamespaces(true)['xml'])['id']);
        $result       = [
            'nom' => (string)$enseignant->nom,
            'modules' => (array)$enseignant->modules->module
        ];

        if ($enseignantId === $id) {
            echo json_encode($result);
            return true;
        }
    }

    echo json_encode([ 'response' => 'error', 'content' =>  'Not found' ]);
    return false;
}
?>
