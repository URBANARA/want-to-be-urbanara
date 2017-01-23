function withdrawal(str) {
    if (str.length == 0) { 
        document.getElementById("notes").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var result = JSON.parse(xmlhttp.responseText);
                for (var key in result) {

                    if (result.hasOwnProperty(key)) {
                        notes.appendChild(document.createTextNode(result[key]+ " note(s) of " + key + " Dollars"));
                            notes.appendChild(document.createElement("hr"));
                    }


                }
            }
        };
        xmlhttp.open("GET", "cash-machine-solution.php?howmuch=" + str, true);
        xmlhttp.send();
    }
}