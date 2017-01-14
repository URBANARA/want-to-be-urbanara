import { takeMoneyOut } from '../src/machine';

describe('Cash Machine', ()=> {

    it('Should get notes 20 and 10 with total 30', ()=> {
        let money = takeMoneyOut(30);
        money.should.have.lengthOf(2);
        money.should.have.to.eql([20, 10]);
    });

    it('Should get notes 50, 20 and 10 with total 80', ()=> {
        let money = takeMoneyOut(80.00);
        money.should.have.lengthOf(3);
        money.should.have.to.eql([50, 20, 10]);
    });

    it('Expect total of 8400', ()=> {
        let money = takeMoneyOut(8400).reduce((initial, number)=>initial + number, 0);
        expect(8400).to.equal(money);
    });

    it('Should be empty', ()=> {
        let money = takeMoneyOut(null);
        money.should.have.lengthOf(0);
        money.should.have.to.eql([]);
    });

    it('Expect Error InvalidArgumentException', ()=> {
        let fn = () => takeMoneyOut(-10);
        expect(fn).to.throw(Error, 'InvalidArgumentException');
    });

    it('Expect Error NoteUnavailableException', ()=> {
        let fn = () => takeMoneyOut(11);
        expect(fn).to.throw(Error, 'NoteUnavailableException');
    });

});