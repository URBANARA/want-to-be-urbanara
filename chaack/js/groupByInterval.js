(function(window, undefined) {

	//Main object
	var urbanara = (function() {

		//Quicksort implementation
		var sort = {
			swap: function(array, indexA, indexB) {
				var temp = array[indexA];
				array[indexA] = array[indexB];
				array[indexB] = temp;
			},

			partition: function(array, pivot, left, right) {
				var storeIndex = left,
				pivotValue = array[pivot];
				this.swap(array, pivot, right);

				for(var i=left; i<right; i++) {
					if(array[i] < pivotValue) {
						this.swap(array, i, storeIndex);
						storeIndex++;
					}
				}

				this.swap(array, right, storeIndex);
    			return storeIndex;
			},

			quicksort: function(array, left, right) {
				var pivot = null;

				if(typeof left !== 'number') left = 0;
				if(typeof right !== 'number') right = array.length - 1;

				if(left < right) {
					pivot = left + Math.ceil((right - left) * 0.5);
					newPivot = this.partition(array, pivot, left, right);

					this.quicksort(array, left, newPivot - 1);
					this.quicksort(array, newPivot + 1, right);
				}
			}
		};

		//Private scope
		var private = {
			//Verify if is an array of numbers
			verifyNumbers: function(numberSet) {
				for(var i=0; i<numberSet.length; i++) {
					if(isNaN(numberSet[i])) {
						throw new Error('InvalidArgumentException');
					}
				}
			},

			//Filter correct params, sort asc and return result
			sortNumbers: function(range, numberSet) {
				if(isNaN(range) 
					|| range == null 
					|| typeof numberSet !== 'object' 
					|| numberSet.length < 2) {
					return [];
				}

				this.verifyNumbers(numberSet);
				sort.quicksort(numberSet);

				return this.sortByInterval(range, numberSet);
			},

			//Sort by interval
			sortByInterval: function(range, numberSet) {
				var output = [];
				var tempGroup = [];

				var min = Math.floor(numberSet[0]/range)*range;
				var max = Math.ceil(numberSet[numberSet.length-1]/range)*range;

				for(var i=min; i<max; i+=range) {
					for(var k=0; k<numberSet.length; k++) {
						if((numberSet[k] < 0 && numberSet[k] >= i && numberSet[k] < i+range)
							|| (numberSet[k] > 0 && numberSet[k] > i && numberSet[k] <= i+range)) {
							tempGroup.push(numberSet[k]);
						}
					}

					if(tempGroup.length > 0)
						output.push(tempGroup);
					
					tempGroup = [];
				}

				return output;
			}
		};
				
		//Public interface
		return {
			groupByInterval: function(range, numberSet) {
				return private.sortNumbers(range, numberSet);
			}
		};
	})();

	window.urbanara = urbanara;
})( window );