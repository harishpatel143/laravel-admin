var TableDatatablesAjax = function () {
    var ajaxParams = {};
    var the;
    var initPickers = function () {
        $("#status").select2();
        $("#role").select2();
    }

    var handleUserRecords = function () {
        var table = $('#user-list').DataTable({
            "responsive": true,
            "searching": false,
            "bSortCellsTop": true,
            "processing": false,
            "serverSide": true,
            "autoWidth": true,
            "oLanguage": {
                "sProcessing": '<img src="/img/loading-spinner-grey.gif"/>&nbsp;&nbsp;<span> Loading </span>'
            },
            "ajax": {
                "type": 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                "url": "/admin/users/get-list", // ajax source,
                "data": function (data) { // add request parameters before submit
                    $.each(ajaxParams, function (key, value) {
                        data[key] = value;
                    });
                }
            },
            "aoColumnDefs": [{"bSortable": false, "aTargets": [0, 5]}],
            "order": []
        });

        table.columns().on('keyup', '.form-filter', function (e) {
            e.preventDefault();
            if (e.keyCode == 13)
            {
                TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
                table.ajax.reload();
            }
        });
        table.columns().on('change', '.form-filter-dropdown', function (e) {
            TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
            table.ajax.reload();
        });
        table.on('click', '.filter-submit', function (e) {
            e.preventDefault();
            TableDatatablesAjax.submitFilter(table);
        });
        // handle filter cancel button click
        table.on('click', '.filter-cancel', function (e) {
            e.preventDefault();
            TableDatatablesAjax.resetFilter(table);
        });
    }

    var handleAdminRecords = function () {
        var table = $('#administrator-list').DataTable({
            "responsive": true,
            "searching": false,
            "bSortCellsTop": true,
            "processing": false,
            "serverSide": true,
            "autoWidth": true,
            "oLanguage": {
                "sProcessing": '<img src="/img/loading-spinner-grey.gif"/>&nbsp;&nbsp;<span> Loading </span>'
            },
            "ajax": {
                "type": 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                "url": "/admin/administrators/get-list", // ajax source,
                "data": function (data) { // add request parameters before submit
                    $.each(ajaxParams, function (key, value) {
                        data[key] = value;
                    });
                }
            },
            "aoColumnDefs": [{"bSortable": false, "aTargets": [0, 6]}],
            "order": []
        });

        table.columns().on('keyup', '.form-filter', function (e) {
            e.preventDefault();
            if (e.keyCode == 13)
            {
                TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
                table.ajax.reload();
            }
        });
        table.columns().on('change', '.form-filter-dropdown', function (e) {
            TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
            table.ajax.reload();
        });
        table.on('click', '.filter-submit', function (e) {
            e.preventDefault();
            TableDatatablesAjax.submitFilter(table);
        });
        // handle filter cancel button click
        table.on('click', '.filter-cancel', function (e) {
            e.preventDefault();
            TableDatatablesAjax.resetFilter(table);
        });
    }

    var handleEmailTemplateRecords = function () {
        var table = $('#email-template-list').DataTable({
            "responsive": true,
            "searching": false,
            "bSortCellsTop": true,
            "processing": false,
            "serverSide": true,
            "autoWidth": true,
            "oLanguage": {
                "sProcessing": '<img src="/img/loading-spinner-grey.gif"/>&nbsp;&nbsp;<span> Loading </span>'
            },
            "ajax": {
                "type": 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                "url": "/admin/email-templates/get-list", // ajax source,
                "data": function (data) { // add request parameters before submit
                    $.each(ajaxParams, function (key, value) {
                        data[key] = value;
                    });
                }
            },
            "aoColumnDefs": [{"bSortable": false, "aTargets": [0, 4]}],
            "order": []
        });
        table.columns().on('keyup', '.form-filter', function (e) {
            e.preventDefault();
            if (e.keyCode == 13)
            {
                TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
                table.ajax.reload();
            }
        });
        table.columns().on('change', '.form-filter-dropdown', function (e) {
            TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
            table.ajax.reload();
        });
        table.on('click', '.filter-submit', function (e) {
            e.preventDefault();
            TableDatatablesAjax.submitFilter(table);
        });
        // handle filter cancel button click
        table.on('click', '.filter-cancel', function (e) {
            e.preventDefault();
            TableDatatablesAjax.resetFilter(table);
        });
    }

    var handleRoleRecords = function () {

        var table = $('#role-list').DataTable({
            "responsive": true,
            "searching": false,
            "bSortCellsTop": true,
            "processing": false,
            "serverSide": true,
            "autoWidth": true,
            "oLanguage": {
                "sProcessing": '<img src="/img/loading-spinner-grey.gif"/>&nbsp;&nbsp;<span> Loading </span>'
            },
            "ajax": {
                "type": 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                "url": "/admin/roles/get-list", // ajax source,
                "data": function (data) { // add request parameters before submit
                    $.each(ajaxParams, function (key, value) {
                        data[key] = value;
                    });
                }
            },
            "aoColumnDefs": [{"bSortable": false, "aTargets": [0, 3]}],
            "order": []
        });
        table.columns().on('keyup', '.form-filter', function (e) {
            e.preventDefault();
            if (e.keyCode == 13)
            {
                TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
                table.ajax.reload();
            }
        });
        table.columns().on('change', '.form-filter-dropdown', function (e) {
            TableDatatablesAjax.setAjaxParam($(this).attr('name'), this.value);
            table.ajax.reload();
        });
        table.on('click', '.filter-submit', function (e) {
            e.preventDefault();
            TableDatatablesAjax.submitFilter(table);
        });
        // handle filter cancel button click
        table.on('click', '.filter-cancel', function (e) {
            e.preventDefault();
            TableDatatablesAjax.resetFilter(table);
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            the = this;
            initPickers();
            handleUserRecords();
            handleAdminRecords();
            handleRoleRecords();
            handleEmailTemplateRecords();
        },
        setAjaxParam: function (name, value) {
            ajaxParams[name] = value;
        },
        submitFilter: function (table) {
            // get all typeable inputs
            $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table.src).each(function () {
                the.setAjaxParam($(this).attr("name"), $(this).val());
            });

            // get all checkboxes
            $('input.form-filter[type="checkbox"]:checked', table.src).each(function () {
                the.addAjaxParam($(this).attr("name"), $(this).val());
            });

            // get all radio buttons
            $('input.form-filter[type="radio"]:checked', table.src).each(function () {
                the.setAjaxParam($(this).attr("name"), $(this).val());
            });

            table.ajax.reload();
        },
        resetFilter: function (table) {
            $('textarea.form-filter, select.form-filter, input.form-filter', table.src).each(function () {
                $(this).val("");
                $("#select2-status-container").html('Select Status');
                $("#role-status-container").html('Select Role');
            });
            $('input.form-filter[type="checkbox"]', table.src).each(function () {
                $(this).attr("checked", false);
            });
            the.clearAjaxParams();
            table.ajax.reload();
        },
        clearAjaxParams: function (name, value) {
            ajaxParams = {};
        }
    };

}();

jQuery(document).ready(function () {    
    TableDatatablesAjax.init();
});