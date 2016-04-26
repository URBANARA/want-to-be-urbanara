<?php
class atm {
    public $notesquantity;
    public $notes;
    public $feedback;

    function __construct() {
      $this->notesquantity = array(0, 0, 0, 0);
      $this->notes = array(100, 50, 20, 10);
    }

    public function withdrawal($value = ""){
      if($value > 0){
        for ($i= 0; $i < sizeof($this->notes); $i++) {
          if($value >= $this->notes[$i]){
            do {
              $value = $value - $this->notes[$i];
              $this->notesquantity[$i]++;
              $this->feedback[$this->notes[$i]] = $this->notesquantity[$i];
            } while ($value >= $this->notes[$i]);
          }
        }
      
      echo json_encode($this->feedback);

      exit;
    }
  }
}
$howmuch = $_REQUEST["howmuch"];
if(!empty($howmuch)){
  $objatm = new atm();
  $objatm->withdrawal($howmuch);
}