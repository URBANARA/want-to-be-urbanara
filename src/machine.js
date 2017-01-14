import NoteUnavailableException from './Exception/NoteUnavailableException';
import InvalidArgumentException from './Exception/InvalidArgumentException';

const notes = [100.00, 50.00, 20.00, 10.00];

let checkIsPostiveNumber = (value) => {
    if (value < 0)
        throw new InvalidArgumentException('InvalidArgumentException');
};

let getNotes = (value) => {
    let listNotes = [];

    while (value > 0) {
        notes.forEach((note) => {
            let mod = value % note;
            if (mod !== value && mod == 0) {
                value -= note;
                listNotes.push(note);
                return;
            }
        });
        if (!listNotes.length)
            throw new NoteUnavailableException('NoteUnavailableException');
    }

    return listNotes.sort((a, b)=>b - a);
}


export function takeMoneyOut(value) {
    checkIsPostiveNumber(value);
    return getNotes(value);
}
