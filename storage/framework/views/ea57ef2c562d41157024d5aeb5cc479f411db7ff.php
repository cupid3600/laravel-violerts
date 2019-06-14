<?php $__env->startComponent('mail::message'); ?>
# Welcome to violerts,

Click the button below to confirm your email and activate your account.

<?php $__env->startComponent('mail::button', ['url' => env('APP_URL').'/user/verification/'.$verification_code ]); ?>
Activate 
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
