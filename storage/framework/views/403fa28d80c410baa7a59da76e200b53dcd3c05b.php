

<?php $__env->startSection('title'); ?>
Users
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Create User
    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route("users.store")); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="required" for="first_name">Name</label>
                <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name" id="name" value="<?php echo e(old('name', '')); ?>" required>
                <?php if($errors->has('name')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('name')); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="required" for="email">Email</label>
                <input class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>" type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required>
                <?php if($errors->has('email')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('email')); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="required" for="degree1">Doctor Specialty</label>
                <input class="form-control" type="text" name="degree1" id="degree1" value="<?php echo e(old('degree1')); ?>">
                <span class="help-block"></span>
            </div>
            
            <div class="form-group">
                <label class="required" for="password">Password</label>
                <input class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>" type="password" name="password" id="password" required>
                <?php if($errors->has('password')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('password')); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">Role</label>
                <select class="form-control select2 <?php echo e($errors->has('roles') ? 'is-invalid' : ''); ?>" name="role" id="role" required>
                        <option value="doctor">Doctor</option>
                        <option value="dentist">Dentist</option>
                        <option value="admin">Admin</option> 
                </select>
                <?php if($errors->has('roles')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('roles')); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projects\doctor-management\resources\views/users/create.blade.php ENDPATH**/ ?>