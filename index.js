const repl = require('repl');
const cli = repl.start('> ');
cli.context.cashMachine = require("./src/cashMachine.js");
cli.context.groupByInterval = require("./src/groupByInterval.js");
console.log("Hello, here you can test 'cashMachine' and 'groupByInterval' functions. Have a nice day. \n"); 