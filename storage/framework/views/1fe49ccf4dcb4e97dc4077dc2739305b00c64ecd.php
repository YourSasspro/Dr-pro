

<?php $__env->startSection('title'); ?>
Users
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        View User
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('users.index')); ?>">
                    Back to List
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            <?php echo e($user->id??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            <?php echo e($user->name??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email
                        </th>
                        <td>
                            <?php echo e($user->email??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Doctor Specialty
                        </th>
                        <td>
                            <?php echo e($user->degree1??''); ?>

                        </td>
                    </tr>
                    
                    <tr>
                        <th>
                            Email Verify
                        </th>
                        <td>
                            <?php echo e($user->email_verified_at); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Role
                        </th>
                        <td>
                                <span class="label label-info"><?php echo e($user->role??''); ?></span>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('users.index')); ?>">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projects\doctor-management\resources\views/users/show.blade.php ENDPATH**/ ?>