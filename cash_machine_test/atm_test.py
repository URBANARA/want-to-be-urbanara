#!/usr/bin/env python
# -*- coding: utf-8 -*-
import unittest
from atm import ATM, InvalidArgumentException, NoteUnavailableException


class ATMTest(unittest.TestCase):
    def test_withdrawal_process(self):
        tested_note_set = [100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 50, 20, 10]
        tested_amount = sum(tested_note_set)
        self.assertEqual(tested_note_set, ATM().withdrawal_process(tested_amount))

        tested_note_set = [50, 20, 10]
        tested_amount = 80
        self.assertEqual(tested_note_set, ATM().withdrawal_process(tested_amount))

        tested_note_set = []
        tested_amount = None
        self.assertEqual(tested_note_set, ATM().withdrawal_process(tested_amount))

        with self.assertRaises(InvalidArgumentException):
            ATM().withdrawal_process(-250)

        with self.assertRaises(NoteUnavailableException):
            ATM().withdrawal_process(125)


if __name__ == '__main__':
    unittest.main()
