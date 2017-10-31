class InvalidArgumentException extends Error {
  constructor(...params) {
    super(...params);
    Error.captureStackTrace(this, InvalidArgumentException);
  }
}

module.exports = InvalidArgumentException;