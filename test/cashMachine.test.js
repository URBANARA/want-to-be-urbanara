const cashMachine = require("../src/cashMachine.js");
const NoteUnavailableException = require("../src/customErrors/NoteUnavailableException.js")
const InvalidArgumentException = require("../src/customErrors/InvalidArgumentException.js")

describe("cashMachine", function () {
  const noteError = "Note is not available."
  const argumentError = "Wrong data provided! Amount should be positive number."

  it("should return empty array if amount is falsy", () => {
    expect(cashMachine()).toEqual([]);
    expect(cashMachine(0)).toEqual([]);
    expect(cashMachine([])).toEqual([]);
    expect(cashMachine("")).toEqual([]);
    expect(cashMachine(null)).toEqual([]);
    expect(cashMachine(NaN)).toEqual([]);
  });

  it("should throw an error if note is not available", () => {
    expect(function () { cashMachine(125) }).toThrow(new NoteUnavailableException(noteError));
  });

  it("should throw an error if amount is negative number", () => {
    expect(function () { cashMachine(-130) }).toThrow(new InvalidArgumentException(argumentError));
  });

  it("should return correct values for amount 30", () => {
    expect(cashMachine(30)).toEqual([20, 10]);
  });

  it("should return correct values for amount 80", () => {
    expect(cashMachine(80)).toEqual([50, 20, 10]);
  });
});
