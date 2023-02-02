<?php
  /** @var $model \app\models\User */
?>
<?php use app\core\form\Form;?>
<h1>Register</h1>
<?php $form = Form::begin('', 'post')?>
  <?php echo $form->field($model, 'name')?>
  <?php echo $form->field($model, 'userName')?>
  <?php echo $form->field($model, 'email')->emailField()?>
  <?php echo $form->field($model, 'password')->passwordField()?>
  <?php echo $form->field($model, 'confirmPassword')->passwordField()?>
  <button type="submit" class="btn btn-primary">Submit</button>
<?php echo Form::end()?>