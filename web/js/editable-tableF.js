var EditableTable = function () {

    return {

        //main function to initiate the module
        init: function () {
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<input type="text" class="form-control small" value="' + aData[3] + '">';
                jqTds[4].innerHTML = '<input type="datetime" class="form-control small" value="' + aData[4] + '">';
                jqTds[5].innerHTML = '<select>' +
                    '<option value="Seminaire">Seminaire</option>'+
                    '<option value="Workshop">Workshop</option>'+
                    '<option value="Culturel">Culturel</option>'+
                    '<option value="Gaming">Gaming</option>'+
                    '<option value="Coding">Coding</option>'+
                    '<option value="Sportif">Sportif</option>'+
                    '<option value="Autre">Autre</option>'+
                '</select>';
                jqTds[6].innerHTML = '<a class="edit" href="">Enregistrer</a>';
                jqTds[7].innerHTML = '<a class="cancel" href="">Annuler</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                var jqInputs2= $('select', nRow);

                oTable.fnUpdate(jqInputs[0].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 3, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 4, false);
                oTable.fnUpdate(jqInputs2[0].value, nRow, 5, false);
                oTable.fnUpdate('<a class="edit" href="">Modifier</a>', nRow, 6, false);
                oTable.fnUpdate('<a class="delete" href="">Supprimer</a>', nRow, 7, false);
                oTable.fnDraw();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
                oTable.fnUpdate('<a class="edit" href="">Modifier</a>', nRow, 5, false);
                oTable.fnDraw();
            }

            var oTable = $('#editable-sample').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown

            var nEditing = null;

            $('#editable-sample_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });

            $('#editable-sample a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Etes-vous sûr de supprimer cet evenement ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                var aData = oTable.fnGetData(nRow);
                var state=$('#methState').val();
                var formData = {
                    id: aData[0],
                    meth:state
                };
                $.ajax({
                    url: Routing.generate('_supprimer_events'),
                    type: 'post',
                    data: formData
                });
                oTable.fnDeleteRow(nRow);
                alert("Evenement supprimé avec succes");
            });

            $('#editable-sample a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample a.edit').live('click', function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Enregistrer") {
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                    var aData = oTable.fnGetData(nRow);
                    var state = $('#methState').val();
                    var formData = {
                        id: aData[0],
                        titre: aData[2],
                        description: aData[3],
                        date: aData[4],
                        type: aData[5],
                        meth:state
                    };
                    $.ajax({
                        url: Routing.generate('_modifier_events'),
                        type:'post',
                        data: formData
                    });
                    alert(JSON.stringify(formData));
                    alert("Evenement modifié avec succes");
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
        }

    };

}();