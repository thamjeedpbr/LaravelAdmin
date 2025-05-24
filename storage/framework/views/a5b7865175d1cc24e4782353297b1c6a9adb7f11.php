<?php echo $__env->yieldContent('css'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<!-- Layout config Js -->
<script src="<?php echo e(URL::asset('assets/js/layout.js')); ?>"></script>
<!-- Bootstrap Css -->
<link href="<?php echo e(URL::asset('assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo e(URL::asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo e(URL::asset('assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('assets/css/custom.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="<?php echo e(URL::asset('assets/css/custom.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<link href="<?php echo e(URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />

<style>
    .btn-link {
    border: none; 
    background: none; 
    padding: 0;
    cursor: pointer;
}

.btn-link:hover {
    color: #007bff; /* Change to your desired hover color */
}

</style><?php /**PATH /Users/thamjeedlal/Herd/detox/resources/views/layouts/head-css.blade.php ENDPATH**/ ?>