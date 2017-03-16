package jgreve.cashMachine.main;

import jgreve.cashMachine.exceptions.InvalidArgumentException;
import jgreve.cashMachine.exceptions.NoteUnavailableException;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Scanner;
import java.util.stream.Collectors;

/**
 * Created by jonathangreve on 2017/03/16.
 * This approach will always make use of the least number of notes based on the fact that the notes are ordered in
 * descending order and the largest denominations will be used first
 */
public class cashMachine {

    private static ArrayList<Double> notes;
    private static ArrayList<Double> disbursement;

    public static void main(String [] args){
        // initialises the availible notes
        notes =  new ArrayList<Double>(Arrays.asList(100.00,50.00,20.00,10.00));
        disbursement =  new ArrayList<Double>();
        System.out.println("Please enter the amount you wish to withdraw: ");
        Scanner scan = new Scanner(System.in);
        int noteIndex = 0;
        double amount = scan.nextDouble();
        // checks to see if the amount enterd is positive
        if(amount < 0){
            try {
                throw new InvalidArgumentException("The amount must be positive");
            } catch (InvalidArgumentException e) {
                e.printStackTrace();
            }
        }
        while(amount >0 ) {
            // check if note fits within the amount to disburse
            if(amount - notes.get(noteIndex) >=0){
                disbursement.add(notes.get(noteIndex));
                amount -= notes.get(noteIndex);
            }
            else{
                // dtermine if note is not availible
                if(noteIndex == notes.size()-1){
                    try {
                        // throw custom exception
                        throw new NoteUnavailableException("Note is not available");
                    } catch (NoteUnavailableException e) {
                        e.printStackTrace();
                    }
                    break;
                }
                else{
                    // note may be availible
                    noteIndex ++;
                }
            }
        }
        // build our response stream
        String response = disbursement.stream().map(Object::toString).collect(Collectors.joining(", "));
        System.out.println("[" + response + "]");
    }
}
