<template>
    <div class="align-items-center border d-inline-flex m-3 p-2 rounded">
        <div>
            <img :src="product.image" class="feature-image" alt="" width="150px" />
        </div>
        <div class="d-flex flex-column" style="padding-right: 5px;">
            <div class="pl-3">
                <div class="product-name"><a href="#" v-html="product.name"></a></div>
                <div class="product-price">
                    <span class="discounted-price" v-if="product.discount > 0"><s>Rs {{ product.price }}</s></span>
                    <span class="price ml-2">Rs. {{ product.price - product.discount }}</span>
                </div>
                <div class="product-description" v-html="product.description"></div>
            </div>
            <div class="align-self-end product-popularity">
                <span><i class="fa fa-star text-warning"></i>123</span>
                <span class="mx-3"><i class="fa fa-comment text-info"></i>123</span>
                <span><i class="fa fa-heart text-danger"></i>123</span>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    props:{
        product:{
            type:Object,
            default:[]
        }
    },
    data(){
        return {
            product:this.product
        }
    },
    updated(){
            console.log(Math.random(), this.product);
    }
}
</script>