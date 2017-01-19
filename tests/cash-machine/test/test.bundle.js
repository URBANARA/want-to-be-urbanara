import { expect } from 'chai';
import sinon from 'sinon';

global.expect = expect;
global.sinon = sinon;

var context = require.context('.', true, /.+\.spec\.js?$/);
context.keys().forEach(context);
module.exports = context;
