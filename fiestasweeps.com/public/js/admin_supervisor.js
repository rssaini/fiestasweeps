updateStatusTransaction = function(id, status){
    openModal('statusChangeModal');
    $('form.statusUpdateForm input[name="id"]').val(id);
    $('form.statusUpdateForm select[name="status"]').val(status);
};

function loadAgents(){
    $.ajax({
        url: '/api/agents'
    }).done(function(data){
        var totalAgents = 0;
        var tableHtml = '';
        if(data.length > 0){
            data.forEach(element => {
                tableHtml += `<tr>
                    <td>${element.id}</td>
                    <td>${element.name}</td>
                    <td>${element.email}</td>
                    <td><span class="status status-${element.status_name}">${element.status_name}</span></td>`;
                if(user.role == 'Admin'){
                    tableHtml += `<td>${element.parent_name}</td>`;
                }
                tableHtml += `<td><button class="btn btn-info" onclick="editAgent(${element.id})"><i class="fa fa-edit"></i></button><button class="btn btn-danger" onclick="deleteAgent(${element.id})"><i class="fa fa-trash"></i></button></td></tr>`;
                if(element.status == 1){
                    totalAgents++;
                }
            });
        } else {
            if(user.role == 'Admin'){
                tableHtml = '<tr><td colspan="6">No Records Found</td></tr>';
            } else {
                tableHtml = '<tr><td colspan="5">No Records Found</td></tr>';
            }
        }
        $('.totalAgents').html(` | ${totalAgents} Active Agents`);
        $('#agents tbody').html(tableHtml);

    }).fail(function(err){});
}

function editAgent(id){
    $.ajax({
        url:`/api/agents/${id}`,
    }).done(function(data){
        openModal('agentEditModal');
        $('#agentEditModal form').attr('action',`/api/agents/${data.data.id}`);
        $('#agentEditModal form input[name="name"]').val(data.data.name);
        $('#agentEditModal form input[name="email"]').val(data.data.email);
        $('#agentEditModal form select[name="status"]').val(data.data.status);
        $('#agentEditModal form [name="parent_id"]').val(data.data.parent_id);
    }).fail(function(err){});
}
function deleteAgent(id){
    Swal.fire({
        title: "Do you really want to delete the agent?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yes",
        denyButtonText: `No`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/agents/${id}`,
                    type: 'delete',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data){
                    if(data.status == "success"){
                        Swal.fire(data.message, "", "success");
                        loadAgents();
                    } else {
                        Swal.fire(data.message, "", "error");
                    }
                }).fail(function(err){
                    console.log(err);
                });
            }
    });
}
