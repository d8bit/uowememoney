
(function() {
    'use strict';
    var date = document.querySelector('#date');
    if (null !== date) {
        date.value = getCurrentDate();
        document.querySelector('#paid_by').value = document.querySelector('#user_id').value;
    }
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

function getCurrentDate() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd<10) {
        dd='0'+dd;
    }

    if (mm<10) {
        mm='0'+mm;
    }

    today = yyyy+'-'+mm+'-'+dd;
    return today;
}


