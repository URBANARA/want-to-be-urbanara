#!/usr/bin/env python
# -*- coding: utf-8 -*-
import sys


class NoteUnavailableException(BaseException):
    pass


class InvalidArgumentException(BaseException):
    pass


class ATM:
    AVAILABLE_NOTES = [100, 50, 20, 10]

    @staticmethod
    def show_menu():
        print("Welcome to the ATM system")
        print("=========================\n")
        print("Usage:\n")
        print("python atm.py <withdrawal_amount>\n")
        print("NOTE: We accept only multiples of ", min(ATM.AVAILABLE_NOTES))

    def withdrawal_process(self, required_amount: int) -> list:
        if required_amount is None:
            return []

        if required_amount <= 0:
            raise InvalidArgumentException("Must be a positive amount")

        if required_amount % min(self.AVAILABLE_NOTES) != 0:
            raise NoteUnavailableException("Amount must be divisible by " + str(min(self.AVAILABLE_NOTES)))

        remaining_amount = required_amount

        withdraw_note_set = []
        for note in self.AVAILABLE_NOTES:
            if remaining_amount == 0:
                break

            tested_note = note
            note_number = remaining_amount // tested_note
            if note_number > 0:
                remaining_amount -= (tested_note * note_number)
                for tested_note in range(note_number):
                    withdraw_note_set.append(note)
            continue

        return withdraw_note_set


if __name__ == '__main__':
    if len(sys.argv) <= 1:
        argument = ''
    else:
        argument = sys.argv[1]

    try:
        print(ATM().withdrawal_process(int(argument)))
    except InvalidArgumentException as ex:
        print('ERROR: ', str(ex))
    except NoteUnavailableException as ex:
        print('ERROR: ', str(ex))
    except ValueError:
        ATM.show_menu()

