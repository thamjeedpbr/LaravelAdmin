<?php $__env->startSection('title'); ?>
    Add Reminder
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css" rel="stylesheet">
    <style>
        .event-preview {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .score-range-info {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }
        .recurrence-options {
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?>
            Add Calendar Event
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Calendar Event for <?php echo e($quiz->title); ?></h4>
                </div>
                <div class="card-body">
                    <form id="reminderForm" class="row g-3">
                        <input type="hidden" name="quiz_id" value="<?php echo e($quiz->id); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="col-md-12">
                            <div class="event-preview p-3 mb-3" id="eventPreview">
                                <h4 class="mb-2" id="previewTitle">Event Title</h4>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-time-five me-2"></i>
                                    <span id="previewDateTime">May 11, 2025, 4:00 PM - 10:00 PM</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-map me-2"></i>
                                    <span id="previewLocation">Location</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-calendar-check me-2"></i>
                                    <span id="previewType">Regular Event</span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-info" id="previewScoreRange">Score Range: 0-100</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter event title" required>
                        </div>

                        <div class="col-md-3">
                            <label for="min_score" class="form-label">Min Score <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="min_score" name="min_score" min="0" value="0" required>
                            <div class="score-range-info">Minimum score to display this event</div>
                        </div>

                        <div class="col-md-3">
                            <label for="max_score" class="form-label">Max Score <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="max_score" name="max_score" min="0" value="100" required>
                            <div class="score-range-info">Maximum score to display this event</div>
                        </div>

                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter event location">
                        </div>

                        <div class="col-md-3">
                            <label for="type" class="form-label">Event Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="event">Regular Event</option>
                                <option value="all-day">All-day Event</option>
                                <option value="recurring">Recurring Event</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="color" class="form-label">Event Color</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>

                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>

                        <div class="col-md-4">
                            <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>

                        <div class="col-md-4">
                            <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>

                        <!-- Recurring event options -->
                        <div class="col-md-12 recurrence-options" id="recurrenceOptions">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Recurrence Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="recurrence_frequency" class="form-label">Frequency</label>
                                            <select class="form-select" id="recurrence_frequency" name="recurrence[frequency]">
                                                <option value="DAILY">Daily</option>
                                                <option value="WEEKLY" selected>Weekly</option>
                                                <option value="MONTHLY">Monthly</option>
                                                <option value="YEARLY">Yearly</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="recurrence_interval" class="form-label">Repeat every</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="recurrence_interval" name="recurrence[interval]" min="1" value="1">
                                                <span class="input-group-text" id="interval_label">week(s)</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">End Recurrence</label>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="recurrence[end_type]" value="never" id="end_never" checked>
                                                <label class="form-check-label" for="end_never">
                                                    Never
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="recurrence[end_type]" value="after" id="end_after">
                                                <label class="form-check-label" for="end_after">
                                                    After
                                                    <input type="number" class="form-control form-control-sm d-inline-block mx-2" style="width: 60px;" name="recurrence[count]" value="10" min="1">
                                                    occurrences
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="recurrence[end_type]" value="on_date" id="end_on_date">
                                                <label class="form-check-label" for="end_on_date">
                                                    On date
                                                    <input type="date" class="form-control form-control-sm mt-1" name="recurrence[until]">
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <!-- Weekly options -->
                                        <div class="col-md-12" id="weeklyOptions">
                                            <label class="form-label">Repeat on</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="recurrence[days][]" value="SU" id="day_su">
                                                    <label class="form-check-label" for="day_su">Sun</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="recurrence[days][]" value="MO" id="day_mo">
                                                    <label class="form-check-label" for="day_mo">Mon</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="recurrence[days][]" value="TU" id="day_tu">
                                                    <label class="form-check-label" for="day_tu">Tue</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="recurrence[days][]" value="WE" id="day_we">
                                                    <label class="form-check-label" for="day_we">Wed</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="recurrence[days][]" value="TH" id="day_th">
                                                    <label class="form-check-label" for="day_th">Thu</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="recurrence[days][]" value="FR" id="day_fr">
                                                    <label class="form-check-label" for="day_fr">Fri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="recurrence[days][]" value="SA" id="day_sa">
                                                    <label class="form-check-label" for="day_sa">Sat</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Monthly options -->
                                        <div class="col-md-12" id="monthlyOptions" style="display: none;">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="recurrence[monthly_type]" value="day_of_month" id="monthly_day" checked>
                                                <label class="form-check-label" for="monthly_day">
                                                    Day 
                                                    <select class="form-select form-select-sm d-inline-block mx-2" style="width: 70px;" name="recurrence[day_of_month]">
                                                        <?php for($i = 1; $i <= 31; $i++): ?>
                                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    of the month
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="recurrence[monthly_type]" value="day_of_week" id="monthly_day_of_week">
                                                <label class="form-check-label" for="monthly_day_of_week">
                                                    The 
                                                    <select class="form-select form-select-sm d-inline-block mx-2" style="width: 100px;" name="recurrence[week_of_month]">
                                                        <option value="1">first</option>
                                                        <option value="2">second</option>
                                                        <option value="3">third</option>
                                                        <option value="4">fourth</option>
                                                        <option value="-1">last</option>
                                                    </select>
                                                    <select class="form-select form-select-sm d-inline-block mx-2" style="width: 100px;" name="recurrence[day_of_week]">
                                                        <option value="SU">Sunday</option>
                                                        <option value="MO">Monday</option>
                                                        <option value="TU">Tuesday</option>
                                                        <option value="WE">Wednesday</option>
                                                        <option value="TH">Thursday</option>
                                                        <option value="FR">Friday</option>
                                                        <option value="SA">Saturday</option>
                                                    </select>
                                                    of the month
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter event description"></textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-end">
                                <a href="<?php echo e(route('reminders.index', $quiz->id)); ?>" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Event</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize color picker
            $("#color").spectrum({
                preferredFormat: "hex",
                showInput: true,
                showPalette: true,
                palette: [
                    ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9"],
                    ["#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12"],
                    ["#e67e22", "#d35400", "#e74c3c", "#c0392b", "#95a5a6", "#7f8c8d"]
                ]
            });

            // Event type change
            $("#type").change(function() {
                if ($(this).val() === 'recurring') {
                    $("#recurrenceOptions").show();
                } else {
                    $("#recurrenceOptions").hide();
                }
                updatePreview();
            });

            // Recurrence frequency change
            $("#recurrence_frequency").change(function() {
                var freq = $(this).val();
                $("#interval_label").text(freq.toLowerCase() === 'daily' ? 'day(s)' : 
                                          freq.toLowerCase() === 'weekly' ? 'week(s)' : 
                                          freq.toLowerCase() === 'monthly' ? 'month(s)' : 'year(s)');
                
                // Show/hide frequency-specific options
                if (freq === 'WEEKLY') {
                    $("#weeklyOptions").show();
                    $("#monthlyOptions").hide();
                } else if (freq === 'MONTHLY') {
                    $("#weeklyOptions").hide();
                    $("#monthlyOptions").show();
                } else {
                    $("#weeklyOptions").hide();
                    $("#monthlyOptions").hide();
                }
                updatePreview();
            });

            // Update preview when inputs change
            $("input, select, textarea").on('change keyup', function() {
                updatePreview();
            });

            // Init preview
            updatePreview();

            // Form submission
            $('#reminderForm').submit(function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: '<?php echo e(route("reminders.store")); ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        
                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        
                        Swal.fire({
                            title: 'Validation Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Function to update preview
            function updatePreview() {
                var title = $("#title").val() || "Event Title";
                var startDate = $("#start_date").val() ? new Date($("#start_date").val()) : new Date();
                var startTime = $("#start_time").val() || "00:00";
                var endTime = $("#end_time").val() || "00:00";
                var location = $("#location").val() || "Location";
                var type = $("#type").val();
                var color = $("#color").spectrum("get") ? $("#color").spectrum("get").toHexString() : "#3498db";
                var minScore = $("#min_score").val() || 0;
                var maxScore = $("#max_score").val() || 100;
                
                // Format date and time
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                var dateStr = startDate.toLocaleDateString(undefined, options);
                var timeStr = "";
                
                if (type === 'all-day') {
                    timeStr = "All day";
                } else {
                    var start = formatTime(startTime);
                    var end = formatTime(endTime);
                    timeStr = start + " - " + end;
                }
                
                // Type label
                var typeLabel = type === 'event' ? 'Regular Event' : 
                                type === 'all-day' ? 'All-day Event' : 
                                'Recurring Event';
                
                // Update preview
                $("#previewTitle").text(title);
                $("#previewDateTime").text(dateStr + ", " + timeStr);
                $("#previewLocation").text(location);
                $("#previewType").text(typeLabel);
                $("#previewScoreRange").text("Score Range: " + minScore + "-" + maxScore);
                
                // Update preview background
                $("#eventPreview").css("background-color", color + "22"); // Add transparency
                $("#eventPreview").css("border-left", "4px solid " + color);
                $("#previewTitle").css("color", color);
            }
            
            // Helper to format time
            function formatTime(timeStr) {
                if (!timeStr) return "";
                var [hours, minutes] = timeStr.split(':');
                var hour = parseInt(hours, 10);
                var ampm = hour >= 12 ? 'PM' : 'AM';
                hour = hour % 12;
                hour = hour ? hour : 12; // the hour '0' should be '12'
                return hour + ':' + minutes + ' ' + ampm;
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/thamjeedlal/Herd/detox/resources/views/admin/reminders/create.blade.php ENDPATH**/ ?>