<?php $__env->startSection('title'); ?>
    Reminders for <?php echo e($quiz->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?>
            Reminders for <?php echo e($quiz->title); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Calendar Events</h4>
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(route('reminders.create', $quiz->id)); ?>">
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="las la-plus"></i>Add Event</button></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="reminderList">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 20px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                            </div>
                                        </th>
                                        <th class="sort" data-sort="title">Title</th>
                                        <th class="sort" data-sort="score_range">Score Range</th>
                                        <th class="sort" data-sort="date">Date</th>
                                        <th class="sort" data-sort="time">Time</th>
                                        <th class="sort" data-sort="location">Location</th>
                                        <th class="sort" data-sort="type">Type</th>
                                        <th class="sort" data-sort="status">Status</th>
                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="form-check-all">
                                    <?php $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="<?php echo e($reminder->id); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <span <?php if($reminder->color): ?> style="color: <?php echo e($reminder->color); ?>;" <?php endif; ?>>
                                                    <?php echo e($reminder->title); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e($reminder->min_score); ?> - <?php echo e($reminder->max_score); ?></td>
                                            <td><?php echo e(date('M d, Y', strtotime($reminder->start_date))); ?></td>
                                            <td><?php echo e(date('g:i A', strtotime($reminder->start_time))); ?> - <?php echo e(date('g:i A', strtotime($reminder->end_time))); ?></td>
                                            <td><?php echo e($reminder->location); ?></td>
                                            <td>
                                                <?php if($reminder->type == 'event'): ?>
                                                    <span class="badge bg-primary">Regular Event</span>
                                                <?php elseif($reminder->type == 'all-day'): ?>
                                                    <span class="badge bg-info">All-day Event</span>
                                                <?php elseif($reminder->type == 'recurring'): ?>
                                                    <span class="badge bg-warning">Recurring Event</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($reminder->is_active): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="<?php echo e(route('reminders.edit', $reminder->id)); ?>" class="btn btn-sm btn-primary editBtn">Edit</a>
                                                    <button class="btn btn-sm btn-danger removeBtn" data-delete-url="<?php echo e(route('reminders.destroy', $reminder->id)); ?>">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div class="noresult" style="display: <?php echo e(count($reminders) === 0 ? 'block' : 'none'); ?>">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">No reminders found</h5>
                                    <p class="text-muted mb-0">Start by adding a new calendar event</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $(document).on('click', '.removeBtn', function () {
        const deleteUrl = $(this).data('delete-url');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
            cancelButtonClass: 'btn btn-danger w-xs mt-2',
            buttonsStyling: false,
            showCloseButton: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/thamjeedlal/Herd/detox/resources/views/admin/reminders/index.blade.php ENDPATH**/ ?>