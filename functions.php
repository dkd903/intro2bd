<?php
    function generate_reco($movies_user_ratings, $person) {
        $total = array();
        $simIlarity_total = array();
        $iranks = array();
        $distmeasure = 0;
        
        foreach($movies_user_ratings as $eachuSer=>$values) {
            if($eachuSer != $person) {
                $distmeasure = simil_dist($movies_user_ratings, $person, $eachuSer);
            }
            
            if($distmeasure > 0) {
                foreach($movies_user_ratings[$eachuSer] as $key=>$value) {
                    if(!array_key_exists($key, $movies_user_ratings[$person])) {
                        if(!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }
                        $total[$key] += $movies_user_ratings[$eachuSer][$key] * $distmeasure;
                        if(!array_key_exists($key, $simIlarity_total)) {
                            $simIlarity_total[$key] = 0;
                        }
                        $simIlarity_total[$key] += $distmeasure;
                    }
                }
                
            }
        }
        foreach($total as $key=>$value){
            $iranks[$key] = $value / $simIlarity_total[$key];
        }
        array_multisort($iranks, SORT_DESC);    
        return $iranks;
    }
    
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
            if(array_key_exists($key, $movies_user_ratings[$pointb]))
                $sum = $sum + pow($value - $movies_user_ratings[$pointb][$key], 2);
        }
        return  1/(1 + sqrt($sum));     
    }
    
    
    /*function matchItems($movies_user_ratings, $person) {
        $score = array();
        foreach($movies_user_ratings as $eachuSer=>$values){
            if($eachuSer !== $person){
                $distmeasure = similarityDistance($movies_user_ratings, $person, $eachuSer);
                if($distmeasure > 0)
                    $score[$eachuSer] = $sim;
            }
        }
        array_multisort($score, SORT_DESC);
        return $score;
    
    }
    
    function transformPreferences($movies_user_ratings) {
        $result = array();
        foreach($movies_user_ratings as $eachuSer => $values){
            foreach($values as $key => $value){
                $result[$key][$eachuSer] = $value;
            }
        }
        return $result;
    }*/