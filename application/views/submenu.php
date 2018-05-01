    <!-- Begin page content -->
    <div class="container">
            <main role="main" style="background-color:#FFFFFF;padding:30px 30px 30px 30px;">        
        <div class="row">
          <div class="col-md-6">
            <h3 style="margin-top:0px;margin-bottom:4px">{dataMenu} <i class="fa fa-angle-double-right"></i> Sub Menu</h3>
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
              <th> Sub Menu Name</th>
              <th>Url</th>
              <th width="100">Level</th>
              <th width="100">Status</th>
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
              <!-- <div class="form-group">
                <label for="exampleInputPassword1">Menu</label>
                <select class="form-control" name="id_menu">
                  <option>-Pilih-</option>
                  {dataMenu}
                  <option value="{id}">{menu_name}</option>
                  {/dataMenu}
                </select>
              </div> -->
              <div class="form-group">
                <label for="exampleInputEmail1">Sub Menu</label>
                <input type="hidden" class="form-control" name="id">
                <input type="hidden" class="form-control" name="id_menu" value="{dataID}">
                <input type="text" class="form-control" name="sub_menu_name" placeholder="Sub Menu Name">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Url</label>
                <input type="text" class="form-control" name="url" placeholder="Url">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Level</label>
                <select class="form-control" name="level">
                  <option>-Pilih-</option>
                  {dataLevel}
                  <option value="{id}">{name_level}</option>
                  {/dataLevel}
                </select>
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
    

