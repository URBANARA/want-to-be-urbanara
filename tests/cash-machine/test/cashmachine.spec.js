import Machine from '../src/cashmachine';
describe('Machine', function() {
  describe('#withDraw', function() {

    it('it should return [20.00, 10.00]', function() {
      const machine = new Machine(30.00);
      expect(machine.withDraw()).to.eql(['20.00', '10.00']);
    });

    it('it should return [50.00, 20.00, 10.00]', function() {
      const machine = new Machine(80.00);
      expect(machine.withDraw()).to.eql(['50.00', '20.00', '10.00']);
    });

    it('it should throw an error NoteUnavailableException', function() {
      const machine = new Machine(125.00);
      expect(machine.withDraw.bind(machine)).to.throw(Error);
    });

    it('it should throw an error InvalidArgumentException', function() {
      const machine = new Machine(-130.00);
      expect(machine.withDraw.bind(machine)).to.throw(Error);
    });

    it('it should throw an error for Null', function() {
      const machine = new Machine(null);
      expect(machine.withDraw()).to.eql([]);
    });
  });
});
