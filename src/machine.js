const notes = [100.00, 50.00, 20.00, 10.00];

let checkIsPostiveNumber = (value) => {
    if (value && value < 0)
        throw Error('GG')
};

let getNotes = (value) => {
    let total = 0;
    let listNotes = [];

    while (value > 0) {
        notes.forEach((note) => {
            let mod = value % note;
            if (mod !== value && mod == 0) {
                value -= note;
                listNotes.push(note)
                total += note;
                return;
            }
        });
        if (!listNotes.length)
            throw Error('GG2')
    }

    return listNote;
};

export
giveMoney = (value) => {
    value = value.toFixed(2);
    checkIsPostiveNumber(value);
    getNotes(value);
};
