<template>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">VUE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <router-link class="nav-link active" to="/">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/contact">Contact</router-link>
                </li>
                <li class="nav-item" v-show="logged">
                    <a href="#" class="nav-link" id="logout" @click.prevent="logout">Logout</a>
                </li>
                <li class="nav-item" v-show="!logged">
                    <router-link class="nav-link" to="/auth">Login/Register</router-link>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <router-view @logEvent="handleLogEvent"/>

</template>

<script>
import { useBearerStore } from './stores/BearerStore.js';

export default {
    data(){
        return {
            logged: false
        }
    },
    methods:{
        handleLogEvent(value){
            this.logged = value;
        },
        logout(){
            if (this.logged) {
                document.getElementById('logout').addEventListener('click', (el) => {
                    const bearerStore = useBearerStore();
                    const _token = bearerStore.getBearer;
                    // console.log("_token", _token);

                    axios.post('logout',{},{
                      headers: {
                        'Authorization': _token,
                      }
                    })
                    .then(response => {
                        this.logged = false;
                        toastr.success(response.data.message);
                        // console.log("this.logged", this.logged);
                    })
                    .catch(error => {
                        if (error.status == 401) {
                            toastr.error('Please login to proceed.');
                            return 0;
                        }
                        console.log("error", error);
                    });
                });
            }
        }
    },
    mounted(){

    }
}
</script>

