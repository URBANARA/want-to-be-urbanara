import React from 'react';
import ReactDOM from 'react-dom';
import { Button } from 'react-bootstrap';

require('../scss/StyleAndStructure.scss');

/* Create ATM component which takes value to treat the data*/
const Atm = React.createClass ({

handleValueChange: function(e) {
   this.setState({newValue: e.target.value});
},
render: function(){
	return(
		<div className="container text-center">
			<div className="row">
			  <h1 className="main-title">React ATM(Cash Machine) </h1>	
			  <h2 className="main-title"> How much do you want to withdraw? </h2>
			  <form id="counter-app">
			    <div id="display-container" className="container">
			      <input type="text" id="display" onChange={this.handleValueChange}></input>
			    </div>
			    <div id="buttons-container" className="container">
			      <button id="increment-button" className="button" onClick={this.handlePrint} type="button"><i className="fa fa-money"></i></button>
			      <button id="reset-button" className="button" type="reset"><i className="fa fa-refresh"></i></button>
			    </div>
			  </form>
		  	</div>
		  	<div className="row">
		  		<ul className="results" id="resultsNode"></ul>
		  	</div>
		</div>
	);
},
handlePrint: function() {

	const ArrayPrimitive = [100, 50, 20, 10];
  	let rest;

	function findChange(m) {
	  return ArrayPrimitive.reduce((mm, c) => {
	    if (mm.rest >= c) {
	      mm.change.push(c);
	      mm.rest -= c
	    }
	    return mm
	  }, {
	    change: [],
	    rest: m
	  });
	}
	let factors = [];
	function findChangeOld(m) {
  	let arr = [100,50,20,10];
    let total = m;
  
    arr.forEach ( d => {
        while ( total >= d ) {
            factors.push ( d );
            rest = total - d;
            total -= d;
            console.log("rest is:"+rest);
        }
    } );

    return factors;
	}

	function calcChange(v) {

	  var c = findChangeOld(v);

        if (v < 0 || isNaN(v)) {
            var node = document.createElement("li");
            var textnode = document.createTextNode(`${v}: throw InvalidArgumentException`);
            node.appendChild(textnode);
            document.getElementById("resultsNode").appendChild(node);

            console.log(`${v}: throw InvalidArgumentException`);
            return;
        }
        if (rest > 0) {
            var node = document.createElement("li");
            var textnode = document.createTextNode(`${v}: throw NoteUnavailableException`);
            node.appendChild(textnode);
            document.getElementById("resultsNode").appendChild(node);


            console.log(`${v}: throw NoteUnavailableException`);
        } else{
            var node = document.createElement("li");
	        var textnode = document.createTextNode(v+":"+ factors);
	        node.appendChild(textnode);
	        document.getElementById("resultsNode").appendChild(node);

       
    	}
    }

	calcChange(this.state.newValue);
    console.log("Value: " + this.state.newValue);
}

});
const Results = React.createClass({
    render: function() {
        return (
            <div id="results" className="search-results">
                Some Results
            </div>
        );
    }
});
/* Wrapper function for ReactDOM.render functionality for the app */
const render = () => {
  ReactDOM.render(
    <Atm />,document.getElementById('app'))
}

/*********
// * REDUX
// **********/

// /* counter takes a default value for state, and an action */
// const counter = (state = 0, action) => {
//   switch (action.type) {
//     case 'INCREMENT':
//       return state + 1;
//     case 'DECREMENT':
//       return state - 1;
//     case 'RESET':
//       return 0;
//     default:
//       return state;
//   }
// }

// /* Import { createStore } from 'redux' */
// const { createStore } = Redux;
// /* store uses counter as its reducer */
// const store = createStore(counter);

// /* When the state in store changes, use this function */
// store.subscribe(render);

render();