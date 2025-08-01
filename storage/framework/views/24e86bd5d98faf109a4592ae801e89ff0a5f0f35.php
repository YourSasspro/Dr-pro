

<?php $__env->startSection('title'); ?>
    Users
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-8">
                    Users List
                </div>
                <div class="col-4">
                    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm float-right "><i
                            class="fa fa-plus"></i> New User</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User" id="table-1">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Doctor Specialty
                            </th>
                            
                            <th>
                                Email Verify
                            </th>
                            <th>
                                Role
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-entry-id="<?php echo e($user->id); ?>">
                                <td>

                                </td>
                                <td>
                                    <?php echo e($user->id ?? ''); ?>

                                </td>
                                <td>
                                    <?php echo e($user->name ?? ''); ?>

                                </td>
                                <td>
                                    <?php echo e($user->email ?? ''); ?>

                                </td>
                                <td>
                                    <?php echo e($user->degree1 ?? ''); ?>

                                </td>
                                
                                <td>
                                    <?php echo e($user->email_verified_at ?? ''); ?>

                                </td>
                                <td>
                                    <span class="badge badge-info"><?php echo e($user->role ?? ''); ?></span>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('users.show', $user->id)); ?>">
                                        View
                                    </a>
                                    <a class="btn btn-xs btn-info" href="<?php echo e(route('users.edit', $user->id)); ?>">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST"
                                        onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>

                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
    <!-- <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_delete')): ?>
                let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete')); ?>'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "<?php echo e(route('users.massDestroy')); ?>",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('<?php echo e(trans('global.datatables.zero_selected')); ?>')

                            return
                        }

                        if (confirm('<?php echo e(trans('global.areYouSure')); ?>')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            <?php endif; ?>

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            $('.datatable-User:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script> -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projects\doctor-management\resources\views/users/index.blade.php ENDPATH**/ ?>