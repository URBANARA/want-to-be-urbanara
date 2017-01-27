class InvalidArgumentException extends Error {
  constructor (message) {
    super(message);
    this.name = 'InvalidArgumentException';
  }
}

class NoteUnavailableException extends Error {
  constructor (message) {
    super(message);
    this.name = 'NoteUnavailableException';
  }
}

class EMPTY_SET extends Error {
  constructor (message) {
    super(message);
    this.name = '[EMPTY SET]';
  }
}

const Errors = {
  EMPTY_SET: {
    message: 'The value must be filled',
    throw: () => {
      try {
        throw new EMPTY_SET(Errors.EMPTY_SET.message);
      } catch (e) {
        throw e.stack;
      }
    }
  },
  InvalidArgumentException: {
    message: 'The value must be positive',
    throw: () => {
      try {
        throw new InvalidArgumentException(Errors.InvalidArgumentException.message);
      } catch (e) {
        throw e.stack;
      }
    }
  },
  NoteUnavailableException: {
    message: `Withdrawal is not possible with the available bills`,
    throw: () => {
      try {
        throw new NoteUnavailableException(Errors.NoteUnavailableException.message);
      } catch (e) {
        throw e.stack;
      }
    }
  }
};

export default Errors;
