<div class="container">
    <div class="clearfix"></div>
    <div>
        <a style="margin: 20px" class="btn btn-primary float-right" href="/admin">Go admin panel</a>
    </div>
    <div class="clearfix"></div>
    <?php if (isset($_GET['status'])) { ?>
        <?php $status = json_decode($_GET['status']); ?>
        <?php if (isset($status->errors)) { ?>
            <div class="errors-box">
                <ul>
                <?php foreach ($status->errors as $error) { ?>
                    <tr>
                        <li><?php echo $error; ?></li>
                    </tr>
                <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <?php if (isset($status->success)) { ?>
            <div class="success-box">
                 <span><?php  echo $status->success; ?></span>
            </div>
        <?php } ?>
    <?php } ?>
    <!-- add task form -->
    <div>
        <div class="row clearfix">
            <div class="col-md-12 table-responsive">
                <form action="<?php echo URL; ?>home/addtask" method="POST">
                    <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                        <thead>
                        <tr>
                            <th class="text-center">
                                Username
                            </th>
                            <th class="text-center">
                                Email
                            </th>
                            <th class="text-center">
                                Notes
                            </th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable">
                        <tr class="hidden">
                            <td data-name="name">
                                <input type="text" name="name" placeholder="Name" class="form-control">
                            </td>
                            <td data-name="mail">
                                <input type="text" name="email" placeholder="Email" class="form-control">
                            </td>
                            <td data-name="desc">
                                <textarea name="desc" placeholder="Description" class="form-control"></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary float-right" name="submit_add_task">Add Task</button>
                </form>
            </div>
        </div>
    </div>

    <!-- main content output -->
    <div>
        <h3>List of tasks </h3>
        <table  id="example" class="table table-striped table-bordered" style="width:100%">
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>Username</td>
                <td>Email</td>
                <td>Note</td>
                <td>Status</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) { ?>
                <tr>
                    <td><?php if (isset($task->id)) echo $task->id; ?></td>
                    <td><?php if (isset($task->user_name)) echo $task->user_name; ?></td>
                    <td><?php if (isset($task->email)) echo $task->email; ?></td>
                    <td><?php if (isset($task->notes)) echo $task->notes; ?>
                    </td>
                    <td>
                        <?php if (!empty($task->status)) { ?>
                        <button class="btn btn-primary">Finished</button>
                        <?php } else { ?>
                            <button class="btn btn-danger">In Process</button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "pageLength": 3
        });
    });
</script>
