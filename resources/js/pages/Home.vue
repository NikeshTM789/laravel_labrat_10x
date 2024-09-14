<style scoped>
</style>

<template>
    <div class="mt-3">
        <search @search="search" :search_results="search_results" :searching="searching"/>
    </div>
    <div class="col-md-10 d-flex flex-column offset-md-1">
        <h3>Recent Posts</h3>

        <product v-for="(product,i) in products" :key="product.slug" :product="product"/>

        <nav aria-label="Page navigation example" class="m-auto">
          <ul class="pagination">
            <li v-for="(v,i) in pagination" :class="{'page-item': true, 'active' : v.active, 'disabled' : (v.url== null)}">
              <a class="page-link" href="#" aria-label="Previous" @click.prevent="fetchProducts(v.url)">
                <span aria-hidden="true" v-html="v.label"></span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
</template>

<script>
import Search from './components/search.vue';
import Product from './components/product.vue';
import SM from './components/modules/search-module.vue';

export default{
    components:{
        Search,
        Product,
        'adv-search' : SM
    },
    data(){
        return {
            domain: window.location.href,
            products:null,
            pagination:null,
            search_results:[],
            searching:false
        }
    },
    methods:{
        fetchProducts(link = this.domain+'api/products'){
            fetch(link)
                .then(response => response.json())
                .then((data) => {
                    this.products = (data.data);
                    this.pagination = (data.meta.links);
                });
        },
        search(key){
            this.searching = true;
            const params = {key};

            axios.get(this.domain+'api/products', {params})
              .then(response => {
                this.search_results = response.data;
              })
              .catch(error => {
                console.error('Error:', error);
              })
              .finally(() => this.searching = false);
        }
    },
    created(){
    },
    beforeMount(){
        this.fetchProducts();

    }
}
</script>