class NoteUnavailableException extends Error {
  constructor(...params) {
    super(...params);
    Error.captureStackTrace(this, NoteUnavailableException);
  }
}

module.exports = NoteUnavailableException;