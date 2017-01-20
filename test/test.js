import {
    CashMachine,
    BalanceLimitException,
    InvalidArgumentException,
    NoteUnavailableException
} from '../src/CashMachine.js';

import chai from 'chai';
const assert = chai.assert;
const expect = chai.expect;
const should = chai.should();
var cm;

describe('CashMachine', function() {
    describe('Withdraw', function() {
        beforeEach(() => {
            cm = new CashMachine(1100);
        })

        it('should return an InvalidArgumentException', function() {
            expect(() => cm.withdraw('ab')).to.throw(InvalidArgumentException);
        });

        it('should return an NoteUnavailableException', function() {
            expect(() => cm.withdraw(39)).to.throw(NoteUnavailableException);
        });

        it('should return an BalanceLimitException', function() {
            expect(() => cm.withdraw(1110)).to.throw(BalanceLimitException);
        });

        it('should return the right notes', function() {
            assert.deepEqual(cm.withdraw(250), [{
                note: 100,
                amount: 2
            }, {
                note: 50,
                amount: 1
            }]);
        });
    });
});
