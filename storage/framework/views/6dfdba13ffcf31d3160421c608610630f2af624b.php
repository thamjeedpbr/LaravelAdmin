<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo e(URL::asset('assets/libs/bootstrap/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/node-waves/node-waves.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/feather-icons/feather-icons.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/plugins.min.js')); ?>"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script src="<?php echo e(URL::asset('/assets/libs/prismjs/prismjs.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/list.js/list.js.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/list.pagination.js/list.pagination.js.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/customAjax.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('script-bottom'); ?>
<script>
    $('#select_main_institute').on('change',function(){
            $('#change_main_institute').submit();
    });
</script>
<script>
    function copyToken(token) {
        // Create a temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = token;
        document.body.appendChild(tempInput);
        
        // Select the text in the input
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text to the clipboard
        document.execCommand('copy');

        // Remove the temporary input element
        document.body.removeChild(tempInput);

        // Optionally, you can show a notification or alert
        alert('Token copied to clipboard!');
    }
</script>
<?php /**PATH /Users/thamjeedlal/Herd/detox/resources/views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>