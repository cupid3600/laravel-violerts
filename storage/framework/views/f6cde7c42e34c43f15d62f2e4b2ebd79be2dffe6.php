<?php $__env->startComponent('mail::message'); ?>
# <?php echo e($property->address); ?>

<br>
## ECB Violation Number:
**<?php echo e($ecb_violation->ecb_number); ?>**
<br>
<?php $__env->startComponent('mail::panel'); ?>
	<?php $__env->startComponent('mail::table'); ?>
		|               |               |
		| ------------- |:-------------:|
		| ** Violation Date **    | <?php echo e($ecb_violation->viol_date); ?> |
		| ** Compliance Status **     | <?php echo e($ecb_violation->bvs_status); ?> |
		| ** Respondent ** | <?php echo e($ecb_violation->respondent); ?> |
	<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>


<?php $__env->startComponent('mail::button', ['url' => env('APP_URL').'/property/overview/'.$property->address]); ?>
	View Property
<?php echo $__env->renderComponent(); ?>

<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>