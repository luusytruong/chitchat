<?php

function hashId( $id ) {
    return 't' . hash( 'sha256', $id );
}

?>