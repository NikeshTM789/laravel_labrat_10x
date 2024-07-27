<style scoped>
.product{
    width: 200px;
}
</style>

<template>
    <div class="container">
        <div class="align-items-start d-flex flex-wrap gap-4 justify-content-between products">
            <div class="card mb-3 product" v-for="(v,i) in products">
              <img :src="v.image" class="card-img-top" alt=""/>
              <div class="card-body">
                <div class="card-title" v-html="getTitle(v.name)"></div>
                <p class="price"><small class="text-muted">Rs. {{ v.price - v.discount }}</small></p>
                <div v-if="v.discount > 0"><s>Rs. {{ v.price }}</s></div>
              </div>
            </div>
        </div>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item" v-for="(v,i) in pagination">
              <a :class="{'page-link': true, 'disabled' : (v.url== null || v.active)}" href="#" aria-label="Previous" @click.prevent="fetchProducts(v.url)">
                <span aria-hidden="true" v-html="v.label"></span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
</template>

<script>
export default{
    data(){
        return {
            domain: window.location.href+'api/',
            products:null,
            pagination:null
        }
    },
    methods:{
        fetchProducts(link = this.domain+'products'){
            fetch(link)
                .then(response => response.json())
                .then((data) => {
                    this.products = (data.data);
                    this.pagination = (data.meta.links);
                });
        },
        getTitle(title){
            return (title.length > 40) ? (title).substring(0,30)+'...' : title;
        }
    },
    created(){
    },
    beforeMount(){
        this.fetchProducts();

    }
}
</script>