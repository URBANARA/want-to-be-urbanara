<?php

/**
 * Created by PhpStorm.
 * User: amiralijiwani
 * Date: 12/06/2016
 * Time: 11:46 PM
 */

namespace AppCode\NoteBox;

use AppCode\Note\FiftyNote;

class FiftyNoteBox extends AbstractNoteBox
{
    public function GetNote()
    {
        return new FiftyNote();
    }
}