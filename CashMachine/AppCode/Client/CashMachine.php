<?php

/**
 * Created by PhpStorm.
 * User: amiralijiwani
 * Date: 12/06/2016
 * Time: 11:39 PM
 */

namespace AppCode\Client;

use AppCode\InputOutput\CashMachineRequest;
use AppCode\InputOutput\CashMachineResponse;
use AppCode\NoteBox\FiftyNoteBox;
use AppCode\NoteBox\HundredNoteBox;
use AppCode\NoteBox\TenNoteBox;
use AppCode\NoteBox\TwentyNoteBox;
use AppCode\Exception\NoteUnavailableException;

class CashMachine
{
    private $noteDeductionChain;

    public function __construct()
    {
        $hundredNoteBox = new HundredNoteBox();
        $fiftyNoteBox = new FiftyNoteBox();
        $twentyNoteBox = new TwentyNoteBox();
        $tenNoteBox = new TenNoteBox();

        $twentyNoteBox->SetNextNoteBox($tenNoteBox);
        $fiftyNoteBox->SetNextNoteBox($twentyNoteBox);
        $hundredNoteBox->SetNextNoteBox($fiftyNoteBox);

        $this->noteDeductionChain = $hundredNoteBox;
    }

    public function WithdrawCash(CashMachineRequest $request)
    {
        $typedAmount = intval($request->GetAmount());
        if ($typedAmount < 0)
        {
            throw new \InvalidArgumentException("Amount must be greater than zero");
        }
        else
        {
            $response = new CashMachineResponse($typedAmount);
            $this->noteDeductionChain->HandleRequest($response);

            if ($response->isAmountConsumed())
            {
                return $response->GetNotes();
            }
            else
            {
                throw new NoteUnavailableException("The notes required for the amount to be consumed is not available");
            }
        }
    }
}