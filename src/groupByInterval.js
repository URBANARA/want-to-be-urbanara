const InvalidArgumentException = require("../src/customErrors/InvalidArgumentException.js")

/**
 * @function groupByInterval
 * Given a disordered group of integer numbers, positives or negatives, 
 * divide the list in disordered groups according to the specified range.
 *
 * @param  {Array.<number>} list - List of integer numbers
 * @param  {number} interval - Specified range
 * @return {Array.<Array.<number>>} - Returns sorted list of number groups 
 */
function groupByInterval(list, interval) {

  // Validate params
  if (!Array.isArray(list) ||
    !list.length ||
    isNaN(interval) ||
    typeof interval !== "number" ||
    interval <= 0) {
    return [];
  }
  // Error handling - check if list elements are numbers
  if (!list.every(x => !isNaN(x) && typeof x === "number")) {
    throw new InvalidArgumentException("Wrong data provided!");
  }

  // Implementation
  let sortedArray = [];
  let givenArray = [...list];

  while (givenArray.length) {
    const currentMin = Math.min(...givenArray);
    let subArray = [currentMin];
    givenArray.splice(givenArray.indexOf(currentMin), 1)

    for (let i = 0; i < givenArray.length; i++) {
      let num = givenArray[i];

      if (Math.abs(num - currentMin) <= interval) {
        subArray.push(num);
        givenArray.splice(i, 1);
        i--; // Hacky way to force loop not skipping over element after splice
      }
    }
    sortedArray.push(subArray);
  }

  return sortedArray;
}

module.exports = groupByInterval;
