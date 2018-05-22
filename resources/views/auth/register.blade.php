{{ config(['app.name' => 'Регистрация']) }}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="pull-left">{{ config('app.name') }}</h1>
            <div class="col-md-12">

                <form class="form-horizontal" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Имя*:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="col-sm-3 error-msg">
                            <div class="help-block help-block-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">E-mail*:</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="col-sm-3 error-msg">
                            <div class="help-block help-block-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Пароль*:</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="col-sm-3 error-msg">
                            <div class="help-block help-block-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-sm-2 control-label">Подтверждение пароля*:</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password-confirm">
                        </div>
                        <div class="col-sm-3 error-msg">
                            <div class="help-block help-block-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="birthdate" class="col-sm-2 control-label">Дата рождения*:</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="birthdate" placeholder="__/__/____" id="birthdate">
                        </div>
                        <div class="col-sm-3 error-msg">
                            <div class="help-block help-block-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="col-sm-2 control-label">Аватар*:</label>
                        <div class="col-sm-7">
                            <input type="file" name="avatar" id="avatar">
                        </div>
                        <div class="col-sm-3 error-msg">
                            <div class="help-block help-block-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-7">
                            <button type="button" class="btn btn-primary pull-right disabled" id="register">Зарегистрироваться</button>
                        </div>
                    </div>

                    <small class="help-block">* Обязательные поля</small>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(_ => {
                let name = new Validation($('#name'), '.{5,}', 'Минимум 5 символов');
                let email = new Validation($('#email'), '.+@.+\\..+', 'Должен быть формат e-mail');
                let password = new Validation($('#password'), '', 'Пароль не может быть пустым', _ => {
                    let passwordVal = $('#password').val();
                    let password_confVal = $('#password-confirm').val();

                    if (password_confVal.length !== 0) {
                        if (password_confVal === passwordVal) {
                            password_conf.success();
                            password.success();
                        } else {
                            let msg = 'Пароли должны совпадать!';
                            password_conf.error(msg);
                            password.error(msg);
                        }
                    } else
                        password.success();
                });
                let password_conf = new Validation($('#password-confirm'), '', 'Пароль не может быть пустым', _ => {
                    let passwordVal = $('#password').val();
                    let password_confVal = $('#password-confirm').val();

                    if (passwordVal.length !== 0) {
                        if (password_confVal === passwordVal) {
                            password.success();
                            password_conf.success();
                        } else {
                            let msg = 'Пароли должны совпадать!';
                            password.error(msg);
                            password_conf.error(msg);
                        }
                    } else
                        password_confVal.success();
                });

                $('#birthdate').datepicker({
                    dateFormat: 'dd/mm/yy',
                    maxDate: '+0d',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: '1940:2018',
                });

                let birthdate = new Validation($('#birthdate'), '[0-9]{2}\/[0-9]{2}\/[0-9]{4}', 'Неверный формат даты!');

                let avatar = new Validation($('#avatar'), '', 'Поле не может быть пустым!', _ => {
                    let file = $('#avatar').prop('files')[0];

                    if (file.type !== 'image/jpeg') return avatar.error('Только формат JPG');
                    if (file.size / 1024 / 1024 > 1) return avatar.error('Не более 1Мб');
                    avatar.success();
                });

            });
        </script>
    @endpush

@endsection
