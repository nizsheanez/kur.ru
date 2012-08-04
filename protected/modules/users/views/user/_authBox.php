<? if (Yii::app()->user->isGuest): ?>
    <li><?= CHtml::link('Войти', '/login?redirect=' . $_SERVER['REQUEST_URI'], array('class' => 'show-modal-link', 'data-modal-id' => 'login-modal')); ?></li>
    <li><?= CHtml::link('Регистрация', '/registration', array('class' => 'show-modal-link', 'data-modal-id' => 'registration-modal')); ?></li>
<? else: ?>
    <li><?= Yii::app()->user->model->getLink(array('class' => 'user-link')); ?></li>
    <li><?= CHtml::link('выйти', '/users/user/logout'); ?></li>
    <li style="padding-top: 9px"><?= Yii::app()->user->model->photo_link ?></li>
<? endif ?>

<div class="modal" id="login-modal">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3><?= t('Авторизация') ?></h3>
    </div>
    <div class="modal-body">
        <p><?= t('Загрузка формы'); ?>…</p>
    </div>
</div>

<div class="modal" id="registration-modal">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3><?= t('Регистрация') ?></h3>
    </div>
    <div class="modal-body">
        <p><?= t('Загрузка формы'); ?>…</p>
    </div>
</div>