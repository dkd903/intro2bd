<?php

    function simil_dist($movies_user_ratings, $pointa, $pointb) {
        $similar = array();
        $sum = 0;
        foreach($movies_user_ratings[$pointa] as $key=>$value){
            if(array_key_exists($key, $movies_user_ratings[$pointb]))
                $similar[$key] = 1;
        }
        if(count($similar) == 0)
            return 0;
        foreach($movies_user_ratings[$pointa] as $key=>$value){
            if(array_key_exists($key, $movies_user_ratings[$pointb])) {
                $sum = $sum + pow($value - $movies_user_ratings[$pointb][$key], 2);
            }
        }
        return  sqrt($sum);     
    }
