var $btnExport;
var data = [];
var url = 'api/clients';

function getData(url) {

    request
        .get(url, {})
        .then(response => {
            if (response.status === 200) {
                data = response.data;
                renderData();
                renderPagination();
            } else {

            }
        })
        .catch(error => {
            console.error(error);
        });

}

function renderData() {

    var clients = data.data;
    var newData = '';

    // clear...
    $('[data-clients-table]').html('');

    // validate...
    if (clients.length == 0) {
        $('[data-clients-table]').html(`
            <tr>
                <td colspan="4" align="center">Add a new client :)</td>
            </tr>
        `);
        return;
    }

    // loop...
    for (let i = 0; i < clients.length; i++) {
        newData +=
            `<tr>
            <td>${clients[i].fullName}</td>
            <td class="text-center">${clients[i].age}</td>
            <td class="text-right">${clients[i].from}</td>
            <td class="text-center">
                <a href="/app/client/edit/${clients[i].id}">Edit</a> | <a href="javascript:;" onClick="deleteClient(${clients[i].id});">Delete</a>
            </td>
        </tr>`;
    }

    // fill..
    $('[data-clients-table]').html(newData);


}

function renderPagination() {

    $('[data-pagination]').html('');

    var html = '';
    var disabled = '';
    var onClick = '';

    $('[data-pagination-total]').html(data.total);
    $('[data-pagination-last]').html(data.last_page);
    $('[data-pagination-current]').html(data.current_page);

    // Previous
    if (data.prev_page_url) {
        disabled = '';
        onClick = `onClick="getData('${data.prev_page_url}')"`;
    } else {
        disabled = 'disabled';
        onClick = '';
    }
    html += `<li class="page-item ${disabled}"><a class="page-link" href="javascript:;" ${onClick}>Previous</a></li>`;

    // here some function to render each page...

    // Previus and Next are equals... :( refactoring soon

    // Next
    if (data.next_page_url) {
        disabled = '';
        onClick = `onClick="getData('${data.next_page_url}')"`;
    } else {
        disabled = 'disabled';
        onClick = '';
    }
    html += `<li class="page-item ${disabled}"><a class="page-link" href="javascript:;" ${onClick}>Next</a></li>`;

    $('[data-pagination]').html(html);


}

function deleteClient(id) {

    Swal({
        title: 'Delete client',
        text: "Are you sure you want to delete this?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            axios
                .delete('/api/clients/' + id)
                .then(response => {
                    if (response.status === 200) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    })



}

$(document).ready(() => {

    getData(url);

    $btnExport = $('#btnExport');

    $btnExport.click(function () {
        $.ajax({
            url: "/api/clients/export",
            method: "POST",
            dataType: "text",
            beforeSend: function () {
                loader.show();
            },
            success: function (data, status, jqxhr) {

                var filename = ""
                var disposition = jqxhr.getResponseHeader('Content-Disposition');

                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) {
                        filename = matches[1].replace(/['"]/g, '');
                    }
                }

                var encodedUri = 'data:application/csv;charset=utf-8,' + encodeURIComponent(data);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", filename);
                document.body.appendChild(link);
                link.click();
            },
            complete: function () {
                loader.hide();
            }
        });
    });

});