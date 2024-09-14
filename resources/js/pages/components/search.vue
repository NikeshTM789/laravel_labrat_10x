<style scoped>
.search-results{
    top: 50px;
    font-size: larger;
    list-style-type: none;
    z-index: 1;
}
.search-results > li:hover{
    background: lightgrey;
    cursor: pointer;
}
</style>
<template>
    <form action="#">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <slot></slot>
                <div class="form-group">
                    <div class="input-group input-group-lg position-relative">
                        <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" @keyup="search_value" :readonly="searching">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i :class="{'fa ':true, 'fa-search':!searching, 'fa-spinner fa-pulse':searching}"></i>
                            </button>
                        </div>
                        <ul :class="{'position-absolute p-0 search-results bg-white w-100': true, 'border': search_results.length, 'd-none': (entered.length<=0)}">
                            <li class="pl-3 p-1" v-if="no_result_found">No Result Found</li>
                            <li class="pl-3 p-1" v-else v-for="result in search_results">{{ result.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default{
    props:{
        search_results:{
            type:Object,
            default:[]
        },
        searching:{
            type:Boolean,
            default:false
        }
    },
    data(){
        return{
            entered:''
        }
    },
    created(){

    },
    methods:{
        search_value:function(ev){
            this.entered = ev.target.value;
            if (this.entered) {
                this.$emit('search', ev.target.value)
            }
        }
    },
    computed: {
        no_result_found() {
          return this.entered.length > 0 && this.search_results.length === 0;
        }
  },
}
</script>
