const AVAILABLE_NOTES = [
	100,
	 50,
	 20,
	 10,
	 20,
	 50,
	100
];

function CashMachine (AVAILABLE_NOTES) {

	if (Object.prototype.toString.call(AVAILABLE_NOTES) !== '[object Array]')
		throw 'InvalidAvailableNoteSException'
	;

	this.AVAILABLE_NOTES = Object.keys(AVAILABLE_NOTES.reduce(function(hash,note){

		// get an array of available notes as numbers > 0
		// (fractionary "notes" are possible, for instance, for coins : )
		// and normalize in a reverse ordered array
		// example: [ 100,50,20,10,20,50,100 ] => [ 100,50,20,10 ]

		if (typeof note != 'number' || note <= 0)
			throw 'InvalidAvailableNoteException'
		;

		hash[note] || (hash[note]=0);
		hash[note] += 1;
		return hash;

	},{})).map(str=>Number(str)).sort((a,b)=>(a<b&&1)||(a>b&&-1)||0);
}

CashMachine.prototype.getAvailableNotes = function () {
	return this.AVAILABLE_NOTES
};

CashMachine.prototype.getNotesFor = function (value) {

	if (value === undefined || value === null)
		return []
	;

	if (typeof value !== 'number' || value < 0)
		throw 'InvalidArgumentException'
	;

	const result = this.AVAILABLE_NOTES.reduce(function(result,note){
		while (result.rest >= note) {
			result.notes.push(note);
			result.rest -= note;
		}
		return result;
	},{notes:[], rest:value});

	if (result.rest)
		throw 'NoteUnavailableException'
	;

	return result.notes;
}

var cashMachine = new CashMachine(AVAILABLE_NOTES);

console.log({availableNotes: cashMachine.getAvailableNotes()});

const TEST = [
	 30,
	 80,
	125,
	-130,
	null,
	undefined,
	0
];

TEST.forEach(function(value){

	try {
		let result = cashMachine.getNotesFor(value);
		console.log({value,result});

	} catch (error) {
		console.log({value,error});
	}

});
