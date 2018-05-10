    <!-- Begin page content -->
    <div class="container">
            <main role="main" style="background-color:#FFFFFF;padding:30px 30px 30px 30px;">        
        <div class="row">
          <div class="col-md-6">
            <h3 style="margin-top:0px;margin-bottom:4px">Data Jenis Pelatihan</h3>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="add()">
              Add Data
            </button>
          </div>
        </div>
        <hr>
        <table class="table table-condensed table-hover" id="table">
          <thead>
            <tr>
              <th width="25">&nbsp;</th>
              <th>Jenis Pelatihan</th>
              <th width="100">Status</th>
              <th width="70"></th>
              <th width="20"></th>
              <th width="20"></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </main>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
            <form id="form">
              <div class="form-group">
                <label for="exampleInputEmail1">Jenis Pelatihan</label>
                <input type="hidden" class="form-control" name="id">
                <input type="text" class="form-control" name="jenis_pelatihan" placeholder="Jenis Pelatihan">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Status</label>
                <select class="form-control" name="status">
                  <option>-Pilih-</option>
                  <option value="1">Active</option>
                  <option value="0">Not Active</option>
                </select>
              </div>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-sm" onclick="saveData()">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    

