<?php

/**
 * Created by PhpStorm.
 * User: amiralijiwani
 * Date: 12/06/2016
 * Time: 11:46 PM
 */

namespace AppCode\NoteBox;

use AppCode\Note\TwentyNote;

class TwentyNoteBox extends AbstractNoteBox
{
    public function GetNote()
    {
        return new TwentyNote();
    }
}