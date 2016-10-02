(function() {
    'use strict';
})();

function addExpense() {

    let data = serialize('add_expense_form');

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if ('' !== this.responseText) {
                console.log('response: ', this.responseText);
            }
        }
    };
    xhttp.open("POST", "addExpense", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);

    document.querySelector('#add_expense_form').reset();
    return false;
}

function serialize(form_id) {
    let response = '';
    let inputs = document.querySelectorAll('#' + form_id +' input');
    inputs.forEach(function(element) {
        let name = encodeURI(element.name);
        let value = encodeURI(element.value);
        response += name + '=' + value + '&';
    });
    let selects = document.querySelectorAll('#' + form_id +' select');
    selects.forEach(function(element) {
        let name = encodeURI(element.name);
        let value = encodeURI(element.value);
        response += name + '=' + value + '&';
    });
    return response;
}
