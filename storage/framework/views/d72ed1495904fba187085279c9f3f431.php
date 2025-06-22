<?php $__env->startSection('title', 'Add Club'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="mb-4">Add Club</h2>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo e(route('clubs.store')); ?>" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
    <?php echo csrf_field(); ?>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Club Name</label>
        <div class="col-sm-9">
            <input type="text" name="club_name" class="form-control" required>
        </div>
    </div>
   <div class="mb-3">
    <label for="logo" class="form-label">Club Logo</label>
    <input type="file" name="logo" class="form-control" accept="image/*">
</div>



    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Introduction</label>
        <div class="col-sm-9">
            <textarea name="introduction" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Mission</label>
        <div class="col-sm-9">
            <textarea name="mission" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Staff Coordinator Name</label>
        <div class="col-sm-9">
            <input type="text" name="staff_coordinator_name" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Staff Email</label>
        <div class="col-sm-9">
            <input type="email" name="staff_coordinator_email" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Staff Photo</label>
        <div class="col-sm-9">
            <input type="file" name="staff_coordinator_photo" class="form-control">
        </div>
    </div>

    

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Year Started</label>
        <div class="col-sm-9">
            <input type="number" name="year_started" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Student Coordinators</label>
        <div class="col-sm-9" id="student-fields">
            <div class="input-group mb-2">
                <input type="text" name="student_names[]" class="form-control me-2" placeholder="Name">
                <input type="file" name="student_photos[]" class="form-control">
            </div>
        </div>
        <div class="col-sm-9 offset-sm-3">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addStudent()">+ Add Another</button>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary" style="background-color: #4d9de0; border: none;">Add Club</button>
    </div>
</form>

<style>
    p:hover {
        color: #0066cc;
    }
</style>

<script>
    function addStudent() {
        const container = document.getElementById('student-fields');
        const div = document.createElement('div');
        div.classList.add('input-group', 'mb-2');
        div.innerHTML = `
            <input type="text" name="student_names[]" class="form-control me-2" placeholder="Name">
            <input type="file" name="student_photos[]" class="form-control">
        `;
        container.appendChild(div);
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\club\kiruthi\adm\tce-clubs\resources\views/clubs/create.blade.php ENDPATH**/ ?>