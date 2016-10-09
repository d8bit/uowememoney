
(function() {
    'use strict';
    resetForm('add_expense_form');
})();

function addExpense() {

    let data = serialize('add_expense_form');

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if ('' !== response.trim()) {
                alert(response);
            } else {
                listExpenses();
                setTotal();
            }
        }
    };
    xhttp.open("POST", "addExpense", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);

    resetForm('add_expense_form');

    return false;
}

function resetForm(form_name) {
    var form = document.querySelector('#' + form_name);
    if (null !== form) {
        form.reset();
        setDate();
    }
}

function serialize(form_id) {
    let response = '';
    let text_inputs = document.querySelectorAll('#' + form_id +' input[type=text]');
    text_inputs.forEach(function(element) {
        let name = encodeURI(element.name);
        let value = encodeURI(element.value);
        response += name + '=' + value + '&';
    });
    let number_inputs = document.querySelectorAll('#' + form_id +' input[type=number]');
    number_inputs.forEach(function(element) {
        let name = encodeURI(element.name);
        let value = encodeURI(element.value);
        response += name + '=' + value + '&';
    });
    let date_inputs = document.querySelectorAll('#' + form_id +' input[type=date]');
    date_inputs.forEach(function(element) {
        let name = encodeURI(element.name);
        let value = encodeURI(element.value);
        response += name + '=' + value + '&';
    });
    let check_inputs = document.querySelectorAll('#' + form_id +' input[type=checkbox]:checked');
    check_inputs.forEach(function(element) {
        let name = encodeURI(element.name);
        let value = encodeURI(element.value);
        response += name + '=' + value + '&';
    });
    let select_inputs = document.querySelectorAll('#' + form_id +' select');
    select_inputs.forEach(function(element) {
        let name = encodeURI(element.name);
        let value = encodeURI(element.value);
        response += name + '=' + value + '&';
    });
    let hidden_inputs = document.querySelectorAll('#' + form_id +' input[type=hidden]');
    hidden_inputs.forEach(function(element) {
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

    if (dd < 10) {
        dd='0'+dd;
    }

    if (mm < 10) {
        mm='0'+mm;
    }

    today = yyyy+'-'+mm+'-'+dd;
    return today;
}

function listExpenses() {
    let html = '';
    let user_id = document.querySelector('#user_id').value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if ('' !== this.responseText) {
                let expenses_list = JSON.parse(this.responseText);
                expenses_list.forEach(function (element) {
                    let date = formatDate(element.date);
                    html += '<div class="col-xs-12 expense"><div class="col-xs-9">'+element.name+': '+element.amount+' € ('+element.paid_by.name+' '+date.toLocaleString()+')';
                    if (element.shared == 0) {
                        html += ' - thief!! -';
                    }
                    html += '</div><div class="col-xs-2 deleteButton" onclick="return deleteExpense('+element.id+')">X</div></div>';
                });
                document.querySelector('#expenses').innerHTML = html;
            }
        }
    };

    xhttp.open("GET", "expenses/" + user_id, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function deleteExpense(expense_id) {
    var r = confirm("Are you shure?");
    if (r === true) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if ('' !== response.trim()) {
                    alert(reponse);
                } else {
                    listExpenses();
                    setTotal();
                }
            }
        };

        xhttp.open("GET", "deleteExpense/" + expense_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }
}

function setTotal() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if ('' !== this.responseText) {
                let total = JSON.parse(this.responseText);
                let html = total.user + " has a debt of " + total.amount+" €";
                document.querySelector('#total').innerHTML = html;
            }
        }
    };

    xhttp.open("GET", "total", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function formatDate(date) {

    var t = date.split(/[- :]/);

    // Apply each element to the Date function
    var my_date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

    // let my_date = new Date(date);
    return my_date.getDate()+'/'+my_date.getMonth()+'/'+my_date.getFullYear();
}

function setDate() {
    var date = document.querySelector('#date');
    if (null !== date) {
        date.value = getCurrentDate();
        document.querySelector('#paid_by').value = document.querySelector('#user_id').value;
    }
}


listExpenses();
setTotal();
