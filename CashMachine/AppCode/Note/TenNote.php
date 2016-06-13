<?php
/**
 * Created by PhpStorm.
 * User: Amirali
 * Date: 6/13/2016
 * Time: 10:54 AM
 */

namespace AppCode\Note;


class TenNote implements INote
{
    public function GetNoteValue()
    {
        return 10;
    }
}