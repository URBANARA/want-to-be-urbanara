let AVAILABLE_BALANCE = 0;
const AVAILABLE_NOTES = [100, 50, 20, 10].sort(function(a, b) {
    return b - a;
});

export class NoteUnavailableException {
    constructor() {
        this.message = 'There are no available notes for this amount.';
        this.name = 'NoteUnavailableException';
    }
}

export class BalanceLimitException {
    constructor() {
        this.message = 'There are no available balance for this amount.';
        this.name = 'BalanceLimitException';
    }
}

export class InvalidArgumentException {
    constructor(value) {
        this.message = `${value} is not a valid value`;
        this.name = 'InvalidArgumentException';
    }
}

export class CashMachine {
    constructor(balance) {
      AVAILABLE_BALANCE = balance || 0;
    }

    _validateValue(value) {
        const lowerNote = AVAILABLE_NOTES[AVAILABLE_NOTES.length - 1];
        // Check empty
        if (!value) {
            return false
        }

        // Check if is a valid number
        if (typeof value !== 'number' || value <= 0) {
            throw new InvalidArgumentException(value);
        }

        // Check notes availability
        if (value % lowerNote > 0) {
            throw new NoteUnavailableException();
        }

        // Check Balance limit
        if (value > AVAILABLE_BALANCE && AVAILABLE_BALANCE !== 0) {
            throw new BalanceLimitException();
        }

        return true;
    }
    _calculateValue(value) {
        let tmpValue = value;
        let amount = 0;
        return AVAILABLE_NOTES.map((note) => {
            if (tmpValue < note) {
                return;
            }
            amount = parseInt(tmpValue / note);
            tmpValue = tmpValue % note;
            return {
                note,
                amount
            };
        }).filter((o) => o);
    }
    withdraw(value) {
        if (this._validateValue(value)) {
            return this._calculateValue(value);
        }
        return 'Empty';
    }
}
