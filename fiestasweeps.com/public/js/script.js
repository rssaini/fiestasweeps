// Tab switching functionality
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(tab => tab.classList.remove('active'));

    // Remove active class from all nav tabs
    const navTabs = document.querySelectorAll('.nav-tab');
    navTabs.forEach(tab => tab.classList.remove('active'));

    // Show selected tab content
    document.getElementById(tabName).classList.add('active');

    // Add active class to clicked nav tab
    event.target.classList.add('active');
    $('#daterange_transaction').data('daterangepicker').setStartDate(moment().subtract(7, 'days').format('MM/DD/YYYY'));
    $('#daterange_transaction').data('daterangepicker').setEndDate(moment().format('MM/DD/YYYY'));
    $('#daterange_cashout').data('daterangepicker').setStartDate(moment().subtract(7, 'days').format('MM/DD/YYYY'));
    $('#daterange_cashout').data('daterangepicker').setEndDate(moment().format('MM/DD/YYYY'));
}

// Modal functionality
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function closeAllModals() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => modal.style.display = 'none');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}

$(document).ready(function() {
    $.get('/api/user').done(function(data){
        user = data;
        $('.user_').html(`${user.name} (${user.role})`);
        if(user.role == 'Admin'){
            loadSupervisors();
            loadAgents();
        }
        if(user.role == 'Supervisor'){
            loadAgents();
        }
        loadHandles();
    });

    $('form').on('submit', function(event) {
        if($(this).attr('id') === 'logoutForm') {
            return true; // Allow logout form to submit normally
        }
        // Prevent default form submission
        event.preventDefault();

        // Serialize form data
        const formData = $(this).serialize();
        const formTag = this;

        // Submit the form via AJAX
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                $(formTag)[0].reset();
                var title = "";
                if($(formTag).hasClass('transactionCreateForm')){
                    loadTransactions();
                    title = "Transaction created successfully!";
                }
                if($(formTag).hasClass('cashoutCreateForm')){
                    loadCashouts();
                    title = "Cashout created successfully!";
                }
                if($(formTag).hasClass('supervisorform')){
                    loadSupervisors();
                    title = response.message;
                }
                if($(formTag).hasClass('gameForm')){
                    loadGames();
                    title = response.message;
                }
                if($(formTag).hasClass('agentForm')){
                    loadAgents();
                    title = response.message;
                }
                if($(formTag).hasClass('paymentHandleForm')){
                    loadHandles();
                    title = response.message;
                }
                if($(formTag).hasClass('statusUpdateForm')){
                    title = "Status updated successfully!";
                    if(response.type == 'deposit'){
                        loadTransactions();
                    }
                    if(response.type == 'cashout'){
                        loadCashouts();
                    }
                }
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: title,
                    showConfirmButton: false,
                    timer: 3000
                });
                closeAllModals();
            },
            error: function(xhr) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    text: xhr.responseJSON.message || 'An error occurred while submitting the form.',
                    title: "Error Submitting Form",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });

    $('#daterange_transaction').daterangepicker({
        opens: 'right',
        drops: 'up',
        autoApply: true,
    }, function(start, end, label) {
        loadTransactions();
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    $('#daterange_cashout').daterangepicker({
        opens: 'right',
        drops: 'up',
        autoApply: true,
    }, function(start, end, label) {
        loadCashouts();
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

});

function loadTransactions() {
    let startDate = $('#daterange_transaction').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let endDate = $('#daterange_transaction').data('daterangepicker').endDate.format('YYYY-MM-DD');
    startDate = moment(startDate).startOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    endDate = moment(endDate).endOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    $('#transactions .pagination-container').pagination({
        dataSource: `/transactions?start_date=${startDate}&end_date=${endDate}`,
        locator: 'data',
        totalNumberLocator: function(response) {
            return response.total; // Assuming the API returns total count in 'total'
        },
        pageSize: 10,
        pageNumber: 1,
        alias: {
            pageNumber: 'page'
        },
        className: 'paginationjs-theme-blue paginationjs-big',
        showSizeChanger: true,
        showNavigator: true,
        formatNavigator: '<%= rangeStart %> - <%= rangeEnd %> of <%= totalNumber %> items',
        ajax: {
            beforeSend: function() {
                const tbody = document.querySelector('#transactions tbody');
                tbody.innerHTML = '<tr><td colspan="10">Loading...</td></tr>'; // Show loading state
            }
        },
        callback: function(data, pagination) {
            const tbody = document.querySelector('#transactions tbody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10">No transactions found.</td></tr>';
                return;
            }
            tbody.innerHTML = ''; // Clear previous data
            data.forEach(transaction => {
                const row = `<tr>
                    <td>${transaction.player_id}</td>
                    <td>${transaction.game?.name}</td>
                    <td>$${transaction.amount}</td>
                    <td>${transaction.handle?.gateway?.name} (${transaction.handle?.account_handle})</td>
                    <td>${transaction.player_handle}</td>
                    <td>${transaction.points}</td>
                    <td>
                        <span>${transaction.created_by ? transaction.created_by.name + ' (' + transaction.created_by.role + ')' : 'N/A'}</span>
                        <br>
                        <span>${new Date(transaction.created_at).toLocaleString()}</span>
                    </td>
                    <td>
                        <span>${transaction.updated_by ? transaction.updated_by.name + ' (' + transaction.updated_by.role + ')' : 'N/A'}</span>
                        <br>
                        <span>${new Date(transaction.updated_at).toLocaleString()}</span>
                    </td>
                    <td><span style="cursor:pointer;" onclick="updateStatusTransaction(${transaction.id}, '${transaction.status}')" class="status ${transaction.status}">${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}</span></td>
                    <td><button class="btn btn-danger" onclick="deleteTransaction(${transaction.id});"><i class="fa fa-trash"></i></button></td>
                </tr>`;
                tbody.innerHTML += row;
            });
        }
    })
}

function exportTransactions(){
    let startDate = $('#daterange_transaction').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let endDate = $('#daterange_transaction').data('daterangepicker').endDate.format('YYYY-MM-DD');
    startDate = moment(startDate).startOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    endDate = moment(endDate).endOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    const userTimezone = moment.tz.guess();
    window.open(`/transactions?export=csv&start_date=${startDate}&end_date=${endDate}`, '_blank');
}

function loadCashouts() {
    let startDate = $('#daterange_cashout').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let endDate = $('#daterange_cashout').data('daterangepicker').endDate.format('YYYY-MM-DD');
    startDate = moment(startDate).startOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    endDate = moment(endDate).endOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    $('#cashouts .pagination-container').pagination({
        dataSource: `/cashouts?start_date=${startDate}&end_date=${endDate}`,
        locator: 'data',
        totalNumberLocator: function(response) {
            return response.total; // Assuming the API returns total count in 'total'
        },
        pageSize: 10,
        pageNumber: 1,
        alias: {
            pageNumber: 'page'
        },
        className: 'paginationjs-theme-blue paginationjs-big',
        showSizeChanger: true,
        showNavigator: true,
        formatNavigator: '<%= rangeStart %> - <%= rangeEnd %> of <%= totalNumber %> items',
        ajax: {
            beforeSend: function() {
                const tbody = document.querySelector('#cashouts tbody');
                tbody.innerHTML = '<tr><td colspan="11">Loading...</td></tr>'; // Show loading state
            }
        },
        callback: function(data, pagination) {
            const tbody = document.querySelector('#cashouts tbody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="11">No Cashouts found.</td></tr>';
                return;
            }
            tbody.innerHTML = ''; // Clear previous data
            data.forEach(cashout => {
                const row = `<tr>
                    <td>${cashout.player_id}</td>
                    <td>${cashout.game?.name}</td>
                    <td>${cashout.last_deposit}</td>
                    <td>${cashout.deposit_handle?.gateway?.name} (${cashout.deposit_handle?.account_handle})</td>
                    <td>${cashout.handle?.gateway?.name} (${cashout.handle?.account_handle})</td>
                    <td>${cashout.player_handle}</td>
                    <td>$${cashout.amount}</td>
                    <td>
                        <span>${cashout.created_by ? cashout.created_by.name + ' (' + cashout.created_by.role + ')' : 'N/A'}</span>
                        <br>
                        <span>${new Date(cashout.created_at).toLocaleString()}</span>
                    </td>
                    <td>
                        <span>${cashout.updated_by ? cashout.updated_by.name + ' (' + cashout.updated_by.role + ')' : 'N/A'}</span>
                        <br>
                        <span>${new Date(cashout.updated_at).toLocaleString()}</span>
                    </td>
                    <td><span style="cursor:pointer;" onclick="updateStatusTransaction(${cashout.id}, '${cashout.status}')" class="status ${cashout.status}">${cashout.status.charAt(0).toUpperCase() + cashout.status.slice(1)}</span></td>
                    <td><button class="btn btn-danger" onclick="deleteCashout(${cashout.id});"><i class="fa fa-trash"></i></button></td>
                </tr>`;
                tbody.innerHTML += row;
            });
        }
    })
}

function exportCashouts() {
    let startDate = $('#daterange_cashout').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let endDate = $('#daterange_cashout').data('daterangepicker').endDate.format('YYYY-MM-DD');
    startDate = moment(startDate).startOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    endDate = moment(endDate).endOf('day').utc().format('YYYY-MM-DD HH:mm:ss');
    const userTimezone = moment.tz.guess();
    window.open(`/cashouts?export=csv&start_date=${startDate}&end_date=${endDate}`, '_blank');
}

function deleteTransaction(id){}

function deleteCashout(id){}

function updateStatusTransaction(id, status){}


function loadHandles(){
    $.ajax({
        url: '/api/handles'
    }).done(function(data){
        var tableHtml = '';
        var optionsHtml = '<option value="">Select Payment Handle</option>';
        if(data.length > 0){
            data.forEach(element => {
                tableHtml += `<tr>
                    <td>${element.id}</td>
                    <td>${element.gateway.name}</td>
                    <td>${element.account_name}</td>
                    <td>${element.account_handle}</td>
                    <td>${element.description}</td>
                    <td><span class="status status-${element.status}">${element.status}</span></td>`;
                if(user.role == 'Admin'){
                    tableHtml += `<td>${element.users[0]?.name}</td>`;
                    tableHtml += `<td><button class="btn btn-info" onclick="editHandle(${element.id})"><i class="fa fa-edit"></i></button><button class="btn btn-danger" onclick="deleteHandle(${element.id})"><i class="fa fa-trash"></i></button></td>`;
                }
                if(element.status == 'active'){
                    optionsHtml += `<option value="${element.id}">${element.gateway.name} (${element.account_handle})</option>`
                }
                tableHtml += `</tr>`;
            });
        } else {
            if(user.role == 'Admin'){
                tableHtml = '<tr><td colspan="8">No Records Found</td></tr>';
            } else {
                tableHtml = '<tr><td colspan="6">No Records Found</td></tr>';
            }
        }
        $('#payment-methods tbody').html(tableHtml);
        $('select.selectPaymentHandles').html(optionsHtml);

    }).fail(function(err){});
}
