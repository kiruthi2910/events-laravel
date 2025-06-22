

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h3 class="mb-4">Edit Event</h3>

    <form action="<?php echo e(route('events.update', $event->id)); ?>" method="POST" enctype="multipart/form-data" class="p-4 shadow rounded bg-white">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" name="event_name" value="<?php echo e($event->event_name); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?php echo e($event->description); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" value="<?php echo e($event->date); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" name="time" value="<?php echo e($event->time); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Event Image</label>
            <input type="file" name="image" class="form-control">
            <?php if($event->image_path): ?>
                <div class="mt-2">
                    <img src="<?php echo e(asset('storage/' . $event->image_path)); ?>" width="180" class="rounded shadow border" alt="Event Image">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success">Update Event</button>
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\club\kiruthi\adm\tce-clubs\resources\views/events/edit.blade.php ENDPATH**/ ?>