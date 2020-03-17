<!-- main content output -->
<div class="container">
    <div align="center" class="container">
        <a style="margin: 20px" class="btn btn-primary float-right" href="<?php echo URL; ?>admin/logout">Logout</a>
    </div>
    <h3>List of tasks (data from first model)</h3>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead style="background-color: #ddd; font-weight: bold;">
        <tr>
            <td>Id</td>
            <td>Username</td>
            <td>Email</td>
            <td>Note</td>
            <td>Status</td>
            <td>Actions</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task) { ?>
            <tr>
                <td><?php if (isset($task->id)) echo $task->id; ?></td>
                <td><?php if (isset($task->user_name)) echo $task->user_name; ?></td>
                <td><?php if (isset($task->email)) echo $task->email; ?></td>
                <td>
                    <textarea id="desc_<?php echo $task->id; ?>" name="desc" placeholder="Description"
                              class="form-control"><?php if (isset($task->notes)) echo trim($task->notes); ?></textarea>
                </td>
                <td>

                    <?php if (!empty($task->status)) { ?>
                        <small class="label label-info"><i class="fa"></i> Finished</small>
                    <?php } else { ?>
                        <small class="label label-danger"><i class="fa"></i>In Process</small>
                    <?php } ?>
                    <?php if (!empty($task->admin_update)) { ?>
                        <small class="label label-info"><i class="fa"></i> Edit by admin</small>
                    <?php } ?>
                </td>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input done" data-id="<?php echo $task->id; ?>"
                               id="defaultChecked_<?php echo $task->id; ?>" <?php if (!empty($task->status)) echo 'checked'; ?> >
                        <label class="custom-control-label" for="defaultChecked_<?php echo $task->id; ?>">Done</label>
                    </div>
                    <div class="custom-control">
                        <button class="btn btn-primary update" data-id="<?php echo $task->id; ?>">Update</button>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {

        $(".done").change(function () {
            var id = $(this).data('id');
            var status = 0;
            if (this.checked) {
                status = 1;
            }

            $.ajax({
                method: "POST",
                url: "/admin/changeStatus",
                data: {id: id, status: status}
            }).done(function (msg) {
                if (msg != 'ok') {
                    location.href = '/admin'
                } else {
                    alert('Update successfuly')
                }
            });
        });

        $(".update").click(function () {
            var id = $(this).data('id');
            var desc = $('#desc_' + id).val();

            $.ajax({
                method: "POST",
                url: "/admin/updateDesc",
                data: {id: id, desc: desc}
            }).done(function (msg) {
                if (msg != 'ok') {
                    location.href = '/admin'
                } else {
                    alert('Update successfuly')
                }
            });

        })


        $('#example').DataTable({
            "pageLength": 3
        });
    });
</script>
