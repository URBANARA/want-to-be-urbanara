/*
 sorting and grouping separated in different objects  which are implemented with a Module Pattern
 */
var InvalidArgumentException = function() {};
var qsorting = (function () {

    /**
     * Sorts an array of numbers
     * @param array
     */
    var sort = function (array) {
        if (!_isArrayCorrect(array)) {
            //suppose what custom error is created even that is PHP error for consistency
            //between team's documentation we can use own custom error objects
            throw new InvalidArgumentException('Q sort handles only numbers primitive sorting');
        }
        // to keep performance of qsort consistent it's necessary to shuffle it
        array = _shuffle(array);
        _sort(array, 0, array.length - 1);
    };

    /**
     * quicksort the sub-array (3-way partitioning)
     * @param array
     * @param lo
     * @param hi
     * @private
     */
    var _sort = function(array, lo, hi) {
        if (hi <= lo) {
            return;
        }

        var lt = lo,
            gt = hi,
            valueAtLowerPosition = array[lo],
            i = lo,
            comparator;

        while (i <= gt) {
            comparator = _compare(array[i], valueAtLowerPosition);
            if (comparator < 0) {
                _swap(array, lt++, i++);
            } else if (comparator > 0) {
                _swap(array, i, gt--);
            } else {
                i++ ;
            }
        }


        _sort(array, lo, lt-1);
        _sort(array, gt+1, hi);
    };

    /**
     * Checks if an array is correct i.e. contains only numbers
     * @param array {Array}
     * @returns {boolean}
     * @private
     */
    var _isArrayCorrect = function (array) {
        var i,
            len = array.length;

        for (i = 0; i < len; i += 1) {
            if (isNaN(array[i])) {
                return false;
            }
        }

        return true;
    };

    /**
     * Returns a shuffled array, Knuth Shuffle implementation
     * @param array {Array}
     * @returns {Array}
     * @private
     */
    var _shuffle = function shuffle(array) {
        var iterationIndex = array.length,
            buffer,
            randomIndex;

        while (iterationIndex !== 0) {
            randomIndex = (Math.random() * iterationIndex) | 0; //fast floor rounding
            iterationIndex -= 1;
            buffer = array[iterationIndex];
            array[iterationIndex] = array[randomIndex];
            array[randomIndex] = buffer;
        }

        return array;
    };

    /**
     * Compares two numbers
     * @param a {number}
     * @param b {number}
     * @returns {number}
     * @private
     */
    var _compare = function (a, b) {
        return a - b;
    };

    /**
     * Swaps elements in array
     * @param array {Array}
     * @param i {number}
     * @param j {number}
     * @private
     */
    var _swap = function (array, i, j) {
        var buffer = array[i];
        array[i] = array[j];
        array[j] = buffer;

        return true;
    };

    return {
        sort: sort
    }

 })();

var grouper = (function (sorting) {
    /**
     *
     * @param range {number}
     * @param array {Array}
     */
    var group = function (range, array) {
        array = array || [];
        range = range || 1;
        //sort array
        try {
            sorting.sort(array)
        } catch (error) {
            throw(error);
        }
        //array.sort();

        var i,
            len = array.length,
            resultArray = [],
            bufferGroup,
            initialGroupValue,
            currentValue;

        //set first element of an array to decrease number of conditions
        initialGroupValue = array[0];
        bufferGroup = [];
        bufferGroup.push(initialGroupValue);

        for (i = 1; i < len; i +=1) {
            currentValue = array[i];
            if (initialGroupValue + range >= currentValue) {
                //add to current group
                bufferGroup.push(currentValue);
            } else {
                //push previous group into result
                resultArray.push(bufferGroup);
                //new group
                bufferGroup = [];
                initialGroupValue = currentValue;
                bufferGroup.push(currentValue);
            }
        }

        //push into result last buffer group
        resultArray.push(bufferGroup);

        return resultArray
    };

    return {
        group: group
    };

})(qsorting);

var groped = grouper.group(15, [10, 1, -20, 'a', 14, 99, 136, 19, 20, 117, 22, 93, 120, 131] );

console.log(groped);