<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Вход</div>
					<div class="card-body">
						
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button v-on:click="login" class="btn btn-primary">
                                    Войти
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
                'email': '',
                'password': '',
                'email_error': '',
                'password_error': '',
                'invalidEmail': false,
                'invalidPassword': false
  			}
  		},
        methods: {
    		login: function () {
                //Передаем токен в запрос
    			jQuery.ajaxSetup({
   					headers: {
    					'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
   					}
				});
                //собираем данные для запроса
                var request = {
                    email : this.email,
                    password : this.password,
                };

                var app = this;
    			$.post("/login", request)
                //При удачном ответе перенаправляем на ленту
                .done(function(){
                    window.location.href = '/rss';
                })
                //Если валидация не прошла, ловим ошибки и размещаем по местам
                .fail(function(response){
    				
    				var json = JSON.parse(response.responseText);
                    var errors = json.errors;
                    app.email_error = app.password_error = "";
                    app.invalidEmail = app.invalidPassword = false;
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