<?php

    trait Funciones{
        
      public function mayuscula($nombre){
        return strtoupper($nombre);
      }

      public function uperCase($nombre){
        return ucfirst(strtolower($nombre));  
      }
    }

?>