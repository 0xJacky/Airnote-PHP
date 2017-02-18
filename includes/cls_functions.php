<?php
/**
* 笺记 API 辅助函数公用类库
* Copyright 2017 0xJacky
**/

class cls_functions
{
  function is_serialized( $data, $strict = true ) {
    // if it isn't a string, it isn't serialized.
    if ( ! is_string( $data ) ) {
      return false;
    }
    $data = trim( $data );
    if ( 'N;' == $data ) {
      return true;
    }
    if ( strlen( $data ) < 4 ) {
      return false;
    }
    if ( ':' !== $data[1] ) {
      return false;
    }
    if ( $strict ) {
      $lastc = substr( $data, -1 );
      if ( ';' !== $lastc && '}' !== $lastc ) {
        return false;
      }
    } else {
      $semicolon = strpos( $data, ';' );
      $brace     = strpos( $data, '}' );
      // Either ; or } must exist.
      if ( false === $semicolon && false === $brace )
      return false;
      // But neither must be in the first X characters.
      if ( false !== $semicolon && $semicolon < 3 )
      return false;
      if ( false !== $brace && $brace < 4 )
      return false;
    }
    $token = $data[0];
    switch ( $token ) {
      case 's' :
      if ( $strict ) {
        if ( '"' !== substr( $data, -2, 1 ) ) {
          return false;
        }
      } elseif ( false === strpos( $data, '"' ) ) {
        return false;
      }
      // or else fall through
      case 'a' :
      case 'O' :
      return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
      case 'b' :
      case 'i' :
      case 'd' :
      $end = $strict ? '$' : '';
      return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
    }
    return false;
  }


  function maybe_serialize( $data ) {
    if ( is_array( $data ) || is_object( $data ) )
    return serialize( $data );
    if ( $this->is_serialized( $data, false ) )
    return serialize( $data );
    return $data;
  }

  function maybe_unserialize( $original ) {
    if ( $this->is_serialized( $original ) )
    { // don't attempt to unserialize data that wasn't serialized going in
      return @unserialize( $original );
    }
    return $original;
  }
  
}

?>
