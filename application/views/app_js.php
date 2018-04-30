    <script type="text/javascript">

      var table, save_method;

      $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url($dataUrl.'/ajax_list')?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{ 
                  "targets": [ -1 ], //last column
                  "orderable": false, //set not orderable
              },
              { 
                  "targets": [ -2 ], //2 last column (photo)
                  "orderable": false, //set not orderable
              },
            ],

        });

      });

      function reload_table()
      {
        table.ajax.reload(null,false); //reload datatable ajax 
      }

      function add()
      {
        save_method = 'add';
        $('#form')[0].reset();
        // $('.form-group').removeClass('has-error');
        // $('.help-block').empty();
        $('#myModal').modal('show');
        $('.modal-title').text('Add Data');
      }

      function saveData()
      {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') {
          url = "<?php echo site_url($dataUrl.'/ajax_add')?>";
        } else {
          url = "<?php echo site_url($dataUrl.'/ajax_update')?>";
        }

        // ajax adding data to database

        var formData = new FormData($('#form')[0]);
          $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data)
            {
              if(data.status) //if success close modal and reload ajax table
              {
                $('#myModal').modal('hide');
                reload_table();
              }else{
                            // for (var i = 0; i < data.inputerror.length; i++) 
                            // {
                                // $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                // $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                            // }
              }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error adding / update data');
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable 
            }
          });
        }

    function editData(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url($dataUrl.'/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('[name="id"]').val(data.id);
          $('[name="id_menu"]').val(data.id_menu);
          $('[name="id_diklat"]').val(data.id_diklat);
          $('[name="name_level"]').val(data.name_level);
          $('[name="menu_name"]').val(data.menu_name);
          $('[name="diklat_name"]').val(data.diklat_name);
          $('[name="subdiklat_name"]').val(data.subdiklat_name);
          $('[name="sub_menu_name"]').val(data.sub_menu_name);
          $('[name="url"]').val(data.url);
          $('[name="name"]').val(data.name);
          $('[name="email"]').val(data.email);
          $('[name="level"]').val(data.level);
          $('[name="status"]').val(data.status);
          $('#myModal').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get data from ajax');
        }
        });
      }

      function deleteData(id)
      {
        if(confirm('Are you sure delete this data?'))
        {
          // ajax delete data to database
          $.ajax({
            url : "<?php echo site_url($dataUrl.'/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error deleting data');
            }
          });
        }
      }
    </script>