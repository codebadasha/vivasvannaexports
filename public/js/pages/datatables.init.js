// General datatable
$(document).ready(function(){
    
    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

	$("#datatable").DataTable(),
	$("#datatable-buttons").DataTable({
		lengthChange:!1,
		"scrollX": true,
        "searching": true,
		buttons:[
            { extend: 'excel',className: 'btn btn-primary' }
        ],
	}).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
	$(".dataTables_length select").addClass("form-select form-select-sm"),
    $("#datatable-buttons-pagination").DataTable({
        lengthChange:!1,
        "scrollX": true,
        buttons:[
            { extend: 'excel',className: 'btn btn-primary' }
        ],
        paging:false,
        sorting:false,
        "searching": true,
    }).buttons().container().appendTo("#datatable-buttons-pagination_wrapper .col-md-6:eq(0)")
});

// Designer Brand Commission datatable
$(document).ready(function() {
    $('#availableVolumeDatatable').DataTable({
        dom: 'Bfrtip',
        lengthChange: !1,
        scrollX: true,
        paging: true,
        scrollCollapse: false,
        responsivePriority: 1,
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-primary',
                exportOptions: {
                    columns: [1, 2, 3],
                    format: {
                        body: function ( inner, rowidx, colidx, node ) {
                            if ($(node).children("input").length > 0) {
                                return $(node).children("input").first().val();
                                //return $(node).children('.select_unit option:selected').first().val()
                            } else {
                                return inner;
                            }
                        }
                    }
                }
            },
        ]
    });
});
