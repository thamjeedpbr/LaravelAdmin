<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-layout="vertical" data-topbar="light" data-sidebar="dark"
    data-sidebar-size="lg">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?>| Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Smart Jamia :: Campus Management Portal" name="description" />
    <meta content="Smart Jamia" name="itwing" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('assets/images/favicon.ico')); ?>">
    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
 
</head>

<?php $__env->startSection('body'); ?>
    <?php echo $__env->make('layouts.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldSection(); ?>
<!-- Begin page -->
<div id="layout-wrapper">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
        <script>
            $('.form-prevent-multiple-submits').on('submit', function() {
                $('.button-prevent-multiple-submits').attr('disabled', true);
                $('.button-prevent-multiple-submits .spinner').show();
            });
            toastr.options = {
                "closeButton": true,
            };
            <?php if(Session::has('success')): ?>
                toastr.success("<?php echo e(Session::get('success')); ?>");
                <?php
                    Session::forget('success');
                ?>
            <?php endif; ?>
        
            <?php if(Session::has('error')): ?>
                toastr.error("<?php echo e(Session::get('error')); ?>");
                <?php
                    Session::forget('error');
                ?>
            <?php endif; ?>
            <?php if(Session::has('warning')): ?>
                toastr.warning("<?php echo e(Session::get('warning')); ?>");
                <?php
                    Session::forget('warning');
                ?>
            <?php endif; ?>
        
            <?php if($errors->any()): ?>
                // <?php
                //     dump($errors->all());
                // ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    toastr.error("<?php echo e($error); ?>");
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </script>
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->



<!-- JAVASCRIPT -->
<?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /Users/thamjeedlal/Herd/detox/resources/views/layouts/master.blade.php ENDPATH**/ ?>