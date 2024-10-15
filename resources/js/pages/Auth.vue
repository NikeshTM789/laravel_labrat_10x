<template>
	<div id="auth-form" class="col-4 mt-5 offset-4">
			<!-- Pills navs -->
	    <ul class="nav nav-tabs justify-content-center nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Register</a>
          </li>
	    </ul>
		<!-- Pills navs -->

		<!-- Pills content -->
	      <div class="card-body">
	        <div class="tab-content" id="custom-tabs-one-tabContent">
	          <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">              
	          	<form @submit.prevent="login" ref="login">
	                <div class="card-body">
	                  <div class="form-group">
	                    <label for="exampleInputEmail1">Email address</label>
	                    <input type="email" name="email" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter email">
	                    <div class="text-danger" v-text="email_err"></div>
	                  </div>
	                  <div class="form-group">
	                    <label for="exampleInputPassword1">Password</label>
	                    <input type="password" name="password" class="form-control form-control-sm" id="exampleInputPassword1" placeholder="Password">
	                    <div class="text-danger" v-text="password_err"></div>
	                  </div>
	                  <div class="form-check">
	                    <input type="checkbox" name="remember_me" class="form-check-input" id="exampleCheck1">
	                    <label class="form-check-label" for="exampleCheck1">remember me</label>
	                  </div>
	                </div>
	                <!-- /.card-body -->
	                <div class="card-footer">
	                  <button type="submit" class="btn btn-primary">Login</button>
	                </div>
	            </form>
          </div>
          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
          	<form @submit.prevent="register" ref="register">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="username" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control form-control-sm" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-sm" id="exampleInputPassword1" placeholder="Password">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
          </div>
	        </div>
	      </div>
		<!-- Pills content -->
	</div>
</template>

<script>
import { useBearerStore } from './../stores/BearerStore.js';

	export default{
		data(){
			return {
				"email_err": null,
				"password_err": null
			}
		},
		methods:{

			login(){
	      const bearerStore = useBearerStore();
				const FD = new FormData(this.$refs.login);

				axios.post('login', FD)
          .then(response => {
                let data = response.data;
                // console.log(data.data.access_token);
                bearerStore.setBearer(data.data.access_token);
                toastr.success(response.data.message);
                this.$emit('logEvent', true);
		            this.$router.push({ name: 'home' });
            })
          .catch(error => {
            // console.error(error);
            if (error.response?.status == 401) {
            	toastr.error(error.response.data.message);
            	return 0;
            }
            let response = error.response.data;
            this.email_err = response.errors.email?.[0];
            this.password_err = response.errors.password?.[0];
          });
			},
			register(){
				console.log("register");
			}
		},
		created(){
		},
		mounted(){
		}
	}
</script>