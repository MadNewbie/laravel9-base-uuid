const axios = require('axios');
const _data = window[`_userIndexData`];
const tableElement = document.getElementById('user-table');
let mainDataTable;

document.addEventListener('DOMContentLoaded', (event) => {
    methods.initDataTable()
})

const methods = {
    initDataTable() {
        const columns = [
            {class:'', data:'name'},
        ];

        if(_data.isPrivilege){
            columns.push({sortable:false, class:'nowrap text-right', data:'_menu'})
        }

        columns.forEach(x => x.searchable = false)

        const afterDrawDt = () => {
            methods.initDeleteButton();
        }

        mainDataTable = $(tableElement)
        .on('draw.dt', afterDrawDt)
        .DataTable({
            columns: columns,
            stateSave: true,
            processing: false,
            serverSide: true,
            ajax: {
                url: _data.routeIndexData,
                type: "GET",
            },
            order: [[0, "desc"]],
        })
    },
    initDeleteButton() {
        const selector = '.btn-destroy';
        const deleteButtons = document.querySelectorAll(selector);
        deleteButtons.forEach(deleteButton => {
            deleteButton.addEventListener('click', (event) => {
                if(!confirm("Data which has been deleted cannot be restored. Are you sure to delete this data?")) return;
                let target = event.target;
                while(!target.matches(selector)){
                    target = target.parentNode;
                }
                const id = target.getAttribute('data-id');
                const url = _data.routeDestroyData.replace('999',id);
                axios.delete(url)
                    .then((response) => {
                        if(response.data == 1){
                            toastr.success("Data berhasil dihapus");
                            mainDataTable.draw(false);
                        } else {
                            toastr.error("Data gagal dihapus")
                        }
                    })
            });
        })
    }
}