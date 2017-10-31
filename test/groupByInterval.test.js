const groupByInterval = require("../src/groupByInterval.js");
const NoteUnavailableException = require("../src/customErrors/NoteUnavailableException.js")

describe("groupByInterval", function () {

  const customError = "Wrong data provided!"

  it("shouldreturn empty array if array is not given", () => {
    expect(groupByInterval("", 10)).toEqual([]);
  });

  it("should return empty array if passed empty array", () => {
    expect( groupByInterval([], 10) ).toEqual([]);
  });

  it("should return correct arrays", () => {
    const testArray = [10, 1, -20, 14, 99, 136, 19, 20, 117, 22, 93, 120, 131];
    expect(groupByInterval(testArray, 10)).toEqual([[-20], [1, 10], [14, 19, 20, 22], [93, 99], [117, 120], [131, 136]]);
    expect(groupByInterval(testArray, 15)).toEqual([[-20], [1, 10, 14], [19, 20, 22], [93, 99], [117, 120, 131], [136]]);
  });

  it("should eturn empty array if interval is not given", () => {
    expect(groupByInterval([1, 2, 3])).toEqual([]);
  });

  it("should eturn empty array if interval is zero or negative number", () => {
    expect(groupByInterval([1, 2, 3], 0)).toEqual([]);
    expect(groupByInterval([1, 2, 3], -10)).toEqual([]);
  });

  it("should return empty array if interval is not number", () => {
    expect(groupByInterval([1, 2, 3], "bla")).toEqual([]);
    expect(groupByInterval([1, 2, 3], [10])).toEqual([]);
    expect(groupByInterval([1, 2, 3], {})).toEqual([]);
    expect(groupByInterval([1, 2, 3], null)).toEqual([]);
    expect(groupByInterval([1, 2, 3], NaN)).toEqual([]);
    expect(groupByInterval([1, 2, 3], undefined)).toEqual([]);
  });

  it("should throw an error if array contains non numbers", () => {
    expect(function () { groupByInterval([1, 2, 3, "bla"], 10) }).toThrow(new TypeError(customError));
    expect(function () { groupByInterval([1, 2, 3, {}], 10) }).toThrow(new TypeError(customError));
    expect(function () { groupByInterval([1, 2, 3, [1, 2, 3]], 10) }).toThrow(new TypeError(customError));
    expect(function () { groupByInterval([1, 2, 3, null], 10) }).toThrow(new TypeError(customError));
    expect(function () { groupByInterval([1, 2, 3, NaN], 10) }).toThrow(new TypeError(customError));
    expect(function () { groupByInterval([1, 2, 3, undefined], 10) }).toThrow(new TypeError(customError));
  });
});
