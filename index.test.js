const withdraw = require('./index').withdraw;

test('withdraw should return empty array for non number input', () => {
  expect(withdraw('100')).toEqual([]);
  expect(withdraw(true)).toEqual([]);
  expect(withdraw()).toEqual([]);
  expect(withdraw(null)).toEqual([]);
});

test('withdraw should throw errors for invalid input', () => {
  expect(() => withdraw(-100)).toThrowError('InvalidArgumentException');
  expect(() => withdraw(17)).toThrowError('NoteUnavailableException');
});

test('withdraw should reutnr correct values', () => {
  expect(withdraw(130)).toEqual([100,20,10]);
  expect(withdraw(80)).toEqual([50,20,10]);
});
