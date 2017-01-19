<?php



class CashMachine{

    private $validNotes = [];

    function __construct($notes = null){
        if(isset($notes))
            $this->validNotes = $notes;
        else
            $this->validNotes = [100,50,20,10];
    }

    function validateValue($value){

        //value is negative, i.e: -130
        if($value < 0){
            try{
                throw new InvalidArgumentException('InvalidArgumentException');
            }catch(Exception $e){
                print_r($e->getMessage());
            }

            return false;
        }
        //value is not a multiple of 10, i.e: 125
        elseif(is_float($value/10)){

            try{
                throw new Exception("NoteUnavailableException");
            }catch(Exception $e){
                echo $e->getMessage();
            }

            return false;
        }
        else{
            return true;
        }
    }

    function withdraw($value){

        if(!$this->validateValue($value)){
            return;
        }

        $notes = [];
        for($i=0 ; $i<count($this->validNotes); $i++){
            //set notes array with the value as array key, and the number of repetition as array val. i.e: [100] => [2] means that the 100 note should be repeated twice
            $notes[$this->validNotes[$i]] = floor($value/$this->validNotes[$i]);
            //set the value to the remaining value
            $value = fmod($value,$this->validNotes[$i]);
        }


        //populate the results array, and format the output
        $notesArr = [];
        foreach ($notes as $val => $num){
            for($j=0 ; $j<$num ; $j++){
                $notesArr[]= number_format($val,2);
            }
        }

        return $notesArr;
    }

}