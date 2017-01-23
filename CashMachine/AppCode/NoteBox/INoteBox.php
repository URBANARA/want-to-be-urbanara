<?php

/**
 * Created by PhpStorm.
 * User: amiralijiwani
 * Date: 12/06/2016
 * Time: 11:41 PM
 */

namespace AppCode\NoteBox;

use AppCode\InputOutput\CashMachineResponse;

interface INoteBox
{
    public function HandleRequest(CashMachineResponse &$request);
    public function SetNextNoteBox(AbstractNoteBox $noteBox);
}