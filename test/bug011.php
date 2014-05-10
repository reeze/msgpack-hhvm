<?php
	
	$items = array( );
	foreach( range( 0, 1024 ) as $r ) {
		$items[] = array(
			'foo' => array( )
		);
	}
	var_dump( count( msgpack_unpack( msgpack_pack( $items ) ) ) );
	
?>