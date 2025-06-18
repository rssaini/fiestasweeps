function loadSupervisors(){
    $.ajax({
        url: '/api/supervisors'
    }).done(function(data){
        var totalSupervisors = 0;
        $('select.activeSupervisorSelect').html('<option value="">Select Supervisor</option>');
        var tableHtml = '';
        var optionHtml = '';
        if(data.length > 0){
            data.forEach(element => {
                tableHtml += `<tr>
                    <td>${element.id}</td>
                    <td>${element.name}</td>
                    <td>${element.email}</td>
                    <td><span class="status status-${element.status_name}">${element.status_name}</span></td>
                    <td><button class="btn btn-info" onclick="editSupervisor(${element.id})"><i class="fa fa-edit"></i></button><button class="btn btn-danger" onclick="deleteSupervisor(${element.id})"><i class="fa fa-trash"></i></button></td>
                </tr>`;
                if(element.status == 1){
                    totalSupervisors++;
                    optionHtml += `<option value="${element.id}">${element.name}</option>`;
                }
            });
        } else {
            tableHtml = '<tr><td colspan="5">No Records Found</td></tr>';
        }
        $('.totalSupervisors').html(` | ${totalSupervisors} Active Supervisors`);
        $('#supervisors tbody').html(tableHtml);
        $('select.activeSupervisorSelect').append(optionHtml);

    }).fail(function(err){});
}

function editSupervisor(id){
    $.ajax({
        url:`/api/supervisors/${id}`,
    }).done(function(data){
        openModal('supervisorEditModal');
        $('#supervisorEditModal form').attr('action',`/api/supervisors/${data.data.id}`);
        $('#supervisorEditModal form input[name="name"]').val(data.data.name);
        $('#supervisorEditModal form input[name="email"]').val(data.data.email);
        $('#supervisorEditModal form select[name="status"]').val(data.data.status);
    }).fail(function(err){});
}
function deleteSupervisor(id){
    Swal.fire({
        title: "Do you really want to delete the supervisor?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yes",
        denyButtonText: `No`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/supervisors/${id}`,
                    type: 'delete',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data){
                    if(data.status == "success"){
                        Swal.fire(data.message, "", "success");
                        loadSupervisors();
                    } else {
                        Swal.fire(data.message, "", "error");
                    }
                }).fail(function(err){
                    console.log(err);
                });
            }
    });
}


function loadGames(){
    $.ajax({
        url: '/api/games'
    }).done(function(data){
        var tableHtml = '';
        if(data.length > 0){
            data.forEach(element => {
                tableHtml += `<tr>
                    <td>${element.id}</td>
                    <td>${element.name}</td>
                    <td>${element.description}</td>
                    <td><button class="btn btn-info" onclick="editGame(${element.id})"><i class="fa fa-edit"></i></button><button class="btn btn-danger" onclick="deleteGame(${element.id})"><i class="fa fa-trash"></i></button></td>
                </tr>`;
            });
        } else {
            tableHtml = '<tr><td colspan="4">No Records Found</td></tr>';
        }
        $('#games tbody').html(tableHtml);

    }).fail(function(err){});
}

function editGame(id){
    $.ajax({
        url:`/api/games/${id}`,
    }).done(function(data){
        openModal('gameEditModal');
        $('#gameEditModal form').attr('action',`/api/games/${data.data.id}`);
        $('#gameEditModal form input[name="name"]').val(data.data.name);
        $('#gameEditModal form input[name="description"]').val(data.data.description);
    }).fail(function(err){});
}
function deleteGame(id){
    Swal.fire({
        title: "Do you really want to delete the Game?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yes",
        denyButtonText: `No`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/games/${id}`,
                    type: 'delete',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data){
                    if(data.status == "success"){
                        Swal.fire(data.message, "", "success");
                        loadGames();
                    } else {
                        Swal.fire(data.message, "", "error");
                    }
                }).fail(function(err){
                    console.log(err);
                });
            }
    });
}

function editHandle(id){
    $.ajax({
        url:`/api/handles/${id}`,
    }).done(function(data){
        openModal('paymentEditModal');
        $('#paymentEditModal form').attr('action',`/api/handles/${data.data.id}`);
        $('#paymentEditModal form select[name="gateway_id"]').val(data.data.gateway_id);
        $('#paymentEditModal form input[name="account_name"]').val(data.data.account_name);
        $('#paymentEditModal form input[name="account_handle"]').val(data.data.account_handle);
        $('#paymentEditModal form input[name="description"]').val(data.data.description);
        $('#paymentEditModal form select[name="status"]').val(data.data.status);
        if(data.data.users.length > 0){
            $('#paymentEditModal form select[name="supervisor"]').val(data.data.users[0].id);
        }
    }).fail(function(err){});
}

function deleteHandle(id){
    Swal.fire({
        title: "Do you really want to delete this Handle?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yes",
        denyButtonText: `No`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/handles/${id}`,
                    type: 'delete',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data){
                    if(data.status == "success"){
                        Swal.fire(data.message, "", "success");
                        loadHandles();
                    } else {
                        Swal.fire(data.message, "", "error");
                    }
                }).fail(function(err){
                    console.log(err);
                });
            }
    });
}

deleteTransaction = function(id) {
    Swal.fire({
        title: "Do you really want to delete the transaction?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yes",
        denyButtonText: `No`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/transactions/${id}`,
                    type: 'delete',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data){
                    if(data.status == "success"){
                        Swal.fire(data.message, "", "success");
                        loadTransactions();
                    } else {
                        Swal.fire(data.message, "", "error");
                    }
                }).fail(function(err){
                    console.log(err);
                });
            }
    });
};

deleteCashout = function(id) {
    Swal.fire({
        title: "Do you really want to delete the cashout?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yes",
        denyButtonText: `No`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/transactions/${id}`,
                    type: 'delete',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data){
                    if(data.status == "success"){
                        Swal.fire(data.message, "", "success");
                        loadCashouts();
                    } else {
                        Swal.fire(data.message, "", "error");
                    }
                }).fail(function(err){
                    console.log(err);
                });
            }
    });
};
