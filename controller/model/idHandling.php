<?php

function hashId( $id ) {
    return 't' . hash( 'sha256', $id );
}

function verifyId($id, $hashedId) {
    $idCurrentHashed = hashId($id);
    return $idCurrentHashed === $hashedId;
}

?>