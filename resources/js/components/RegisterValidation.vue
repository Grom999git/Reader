<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Регистрация</div>
					<div class="card-body">
						
							<div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" v-bind:class="{'is-invalid': invalidName}" name="name" value="" required autocomplete="name" autofocus v-model="name">

                                    <span class="invalid-feedback" role="alert" >
                                        <strong>{{name_error}}</strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Адрес</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-bind:class="{'is-invalid': invalidEmail}" name="email" value="" required autocomplete="email" v-model="email">

                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{email_error}}</strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control"
                                v-bind:class="{'is-invalid': invalidPassword}" v-model="password">

                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{password_error}}</strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтверждение пароля</label>

                            <div class="col-md-6">
                                <input id="p-confirmed" type="password" class="form-control" v-model="passwordConfirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button v-on:click="register" class="btn btn-primary">
                                    Регистрация
                                </button>
                            </div>
                        </div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
    export default {
    	data: function(){
    		return{
                'name': '',
                'email': '',
                'password': '',
                'passwordConfirmation': '',
                'name_error': '',
                'email_error': '',
                'password_error': '',
                'invalidName': false,
                'invalidEmail': false,
                'invalidPassword': false
  			}
  		},
        methods: {
    		register: function () {

    			jQuery.ajaxSetup({
   					headers: {
    					'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
   					}
				});
                //собираем данные для запроса
                var request = {
                    name : this.name,
                    email : this.email,
                    password : this.password,
                    password_confirmation : this.passwordConfirmation
                };

                var app = this;
    			$.post("/register", request)
                //При удачном ответе перенаправляем на ленту
                .done(function(){
                    window.location.href = "/rss";
                })
                //Если валидация не прошла, ловим ошибки и размещаем по местам
                .fail(function(response){
    				
    				var json = JSON.parse(response.responseText);
                    var errors = json.errors;
                    app.name_error = app.email_error = app.password_error = "";
                    app.invalidName = app.invalidEmail = app.invalidPassword = false;
                    if(errors.name !== undefined){
                        app.name_error = errors.name[0]
                        app.invalidName = true;
                    };
                    if(errors.email !== undefined){
                        app.email_error = errors.email[0]
                        app.invalidEmail = true;
                    };
                    if(errors.password !== undefined){
                        app.password_error = errors.password[0]
                        app.invalidPassword = true;
                    };
                    console.log(JSON.parse(response.responseText));
  				});

      		
    		

    		}
  		}
    }
</script>