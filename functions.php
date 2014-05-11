<?php
    function simil_dist($movies_user_ratings, $person1, $person2) {
        $similar = array();
        $sum = 0;
        foreach($movies_user_ratings[$person1] as $key=>$value){
            if(array_key_exists($key, $movies_user_ratings[$person2]))
                $similar[$key] = 1;
        }
        if(count($similar) == 0)
            return 0;
        foreach($movies_user_ratings[$person1] as $key=>$value){
            if(array_key_exists($key, $movies_user_ratings[$person2]))
                $sum = $sum + pow($value - $movies_user_ratings[$person2][$key], 2);
        }
        return  1/(1 + sqrt($sum));     
    }
    
    
    /*function matchItems($movies_user_ratings, $person) {
        $score = array();
        foreach($movies_user_ratings as $otherPerson=>$values){
            if($otherPerson !== $person){
                $distmeasure = similarityDistance($movies_user_ratings, $person, $otherPerson);
                if($distmeasure > 0)
                    $score[$otherPerson] = $sim;
            }
        }
        array_multisort($score, SORT_DESC);
        return $score;
    
    }
    
    function transformPreferences($movies_user_ratings) {
        $result = array();
        foreach($movies_user_ratings as $otherPerson => $values){
            foreach($values as $key => $value){
                $result[$key][$otherPerson] = $value;
            }
        }
        return $result;
    }*/
    
    
    function generate_reco($movies_user_ratings, $person) {
        $total = array();
        $simSums = array();
        $ranks = array();
        $distmeasure = 0;
        
        foreach($movies_user_ratings as $otherPerson=>$values) {
            if($otherPerson != $person) {
                $distmeasure = simil_dist($movies_user_ratings, $person, $otherPerson);
            }
            
            if($distmeasure > 0) {
                foreach($movies_user_ratings[$otherPerson] as $key=>$value) {
                    if(!array_key_exists($key, $movies_user_ratings[$person])) {
                        if(!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }
                        $total[$key] += $movies_user_ratings[$otherPerson][$key] * $distmeasure;
                        if(!array_key_exists($key, $simSums)) {
                            $simSums[$key] = 0;
                        }
                        $simSums[$key] += $distmeasure;
                    }
                }
                
            }
        }
        foreach($total as $key=>$value){
            $ranks[$key] = $value / $simSums[$key];
        }
        array_multisort($ranks, SORT_DESC);    
        return $ranks;
    }