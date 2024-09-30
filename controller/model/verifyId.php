<?php

include __DIR__ . '/hashId.php';

function verifyId($id, $hashedId) {
    $idCurrentHashed = hashId($id);
    return $idCurrentHashed === $hashedId;
}


?>