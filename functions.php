<?php
    function similarityDistance($preferences, $person1, $person2) {
        $similar = array();
        $sum = 0;
        foreach($preferences[$person1] as $key=>$value){
            if(array_key_exists($key, $preferences[$person2]))
                $similar[$key] = 1;
        }
        if(count($similar) == 0)
            return 0;
        foreach($preferences[$person1] as $key=>$value){
            if(array_key_exists($key, $preferences[$person2]))
                $sum = $sum + pow($value - $preferences[$person2][$key], 2);
        }
        return  1/(1 + sqrt($sum));     
    }
    
    
    function matchItems($preferences, $person) {
        $score = array();
        foreach($preferences as $otherPerson=>$values){
            if($otherPerson !== $person){
                $dist = similarityDistance($preferences, $person, $otherPerson);
                if($dist > 0)
                    $score[$otherPerson] = $sim;
            }
        }
        array_multisort($score, SORT_DESC);
        return $score;
    
    }
    
    function transformPreferences($preferences) {
        $result = array();
        foreach($preferences as $otherPerson => $values){
            foreach($values as $key => $value){
                $result[$key][$otherPerson] = $value;
            }
        }
        return $result;
    }
    
    
    function getRecommendations($preferences, $person) {
        $total = array();
        $simSums = array();
        $ranks = array();
        $dist = 0;
        
        foreach($preferences as $otherPerson=>$values) {
            if($otherPerson != $person) {
                $dist = similarityDistance($preferences, $person, $otherPerson);
            }
            
            if($dist > 0) {
                foreach($preferences[$otherPerson] as $key=>$value) {
                    if(!array_key_exists($key, $preferences[$person])) {
                        if(!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }
                        $total[$key] += $preferences[$otherPerson][$key] * $sim;
                        if(!array_key_exists($key, $simSums)) {
                            $simSums[$key] = 0;
                        }
                        $simSums[$key] += $sim;
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