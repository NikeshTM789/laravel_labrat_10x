<style scoped>
  #detail {
    max-height: 150px;
    overflow: hidden;
    margin-top: 3rem;
  }

  #comment-card {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      padding: 20px;
      word-wrap: break-word;
      background-color: #fff;
      background-clip: border-box;
      border-radius: 6px;
      -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1)
  }

  .comment-box{
      padding:5px;
  }

  .comment-area textarea{
    resize: none; 
    border: 1px solid #ad9f9f;
  }

  .form-control:focus {
      color: lightblue;
      background-color: #fff;
      border-color: #ffffff;
      outline: 0;
      box-shadow: 0 0 0 1px #0846f7 !important;
  }

  .rating {
    display: flex;
    margin-top: -10px;
    flex-direction: row-reverse;
    margin-left: -4px;
    float: left;
  }

  .rating>input {
    display: none
  }

  .rating>label {
    position: relative;
    width: 19px;
    font-size: 25px;
    cursor: pointer;
  }

  .rating>label::before {
      content: "\2605";
      position: absolute;
      opacity: 0
  }

  .rating>label:hover:before,
  .rating>label:hover~label:before {
      opacity: 1 !important
  }

  .rating>input:checked~label:before {
      opacity: 1
  }

  .rating:hover>input:checked~label:before {
      opacity: 0.4
  }
</style>

<template>
  <!-- Main content -->
  <section class="content" v-if="product">
    <!-- Default box -->
    <div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="col-12">
              <img :src="product.gallery[0]" class="product-image" :alt="`Gallery Image of ${product.name}`">
            </div>
            <div class="col-12 product-image-thumbs" ref="pit">
              <div
                v-for="(image, key) in product.gallery"
                :key="key"
                :class="{'product-image-thumb': true, 'active': key == 0}"
              >
                <img :src="image" :alt="`Thumbnail Image of ${product.name}`">
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <h3 class="my-3" v-text="product.name"></h3>

            <hr>

            <div class="bg-gray py-2 px-3 mt-4">
              <h2 class="mb-0">$80.00</h2>
              <h4 class="mt-0">
                <small>Ex Tax: $80.00</small>
              </h4>
            </div>

            <div class="mt-4">
              <div class="btn btn-primary btn-lg btn-flat">
                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                Add to Cart
              </div>
            </div>
          </div>
        </div>

        <!-- Product Description -->
        <div id="detail" ref="detail" v-html="product.description"></div>
        <div class="text-center mt-3" v-if="product.description">
          <button class="moreless-button btn btn-outline-dark btn-xs moreless-button">Read more</button>
        </div>
      </div>

      <!-- Comment Section -->
      <div id="comment-card">
        <div class="row">
          <div class="col-10 offset-2">
            <div class="comment-box ml-2">
              <h4>Add a comment</h4>
              <!-- Rating Section -->
              <form>
                <div class="rating">
                  <input type="radio" name="rating" value="5" id="5">
                  <label for="5" class="text-warning">☆</label>
                  <input type="radio" name="rating" value="4" id="4">
                  <label for="4" class="text-warning">☆</label>
                  <input type="radio" name="rating" value="3" id="3">
                  <label for="3" class="text-warning">☆</label>
                  <input type="radio" name="rating" value="2" id="2">
                  <label for="2" class="text-warning">☆</label>
                  <input type="radio" name="rating" value="1" id="1">
                  <label for="1" class="text-warning">☆</label>
                </div>
              </form>

              <!-- Comment Area -->
              <div class="comment-area">
                <textarea id="comment-area" class="form-control" placeholder="What is your view?" rows="4"></textarea>
              </div>

              <!-- Comment Buttons -->
              <div class="comment-btns mt-2">
                <div class="row">
                  <div class="col-12">
                    <div class="pull-right">
                      <button class="btn btn-success send btn-sm">Send</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Product Comments -->
          <div id="product-comments" class="col-md-10 mt-5 offset-2">
            <div class="border">
              <div class="comment p-3">
                <div class="d-flex justify-content-between">
                  <div><b>Johanson</b></div>
                  <div>24 May 2024</div>
                </div>
                <div class="my-2">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi id odio, perspiciatis amet eum quisquam iure cupiditate esse debitis accusantium!
                </div>
                <div class="d-flex justify-content-between">
                  <div>
                    <span><i class="fa fa-star text-warning"></i></span>
                    <span><i class="fa fa-star text-warning"></i></span>
                    <span><i class="fa fa-star text-warning"></i></span>
                  </div>
                  <div>
                    <div class="pr-5 reply"><a href="#">reply</a></div>
                    <div class="replies"><a href="#">replies(3)</a></div>
                  </div>
                </div>
              </div>
              <div class="offset-1 subcomment">
                <div class="comment p-3">
                  <div class="d-flex justify-content-between">
                    <div><b>Johanson</b></div>
                    <div>24 May 2024</div>
                  </div>
                  <div class="my-2">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi id odio, perspiciatis amet eum quisquam iure cupiditate esse debitis accusantium!
                  </div>
                </div>
              </div>
            </div>
            <div class="load-more text-center mt-3"><button class="btn btn-outline-info btn-xs">load more</button></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.content -->
</template>


<script>
	export default{
		data(){
			return{
				uuid: this.$route.params.uuid,
				product: null
			}
		},
		created(){
			const self = this;
			const params = {uuid: self.uuid};

	        axios.get('/single/'+self.uuid)
	          .then(response => {
	          	this.product = response.data.data;
	          })
	          .catch(error => {
	            console.error('Error:', error);
	          })
            .finally(() => {
              const self = this;
        	    $('.product-image-thumb').on('click', function () {
        	      var $image_element = $(this).find('img');
        	      $('.product-image').prop('src', $image_element.attr('src'));
        	      $('.product-image-thumb.active').removeClass('active');
        	      $(this).addClass('active');
        	    });
              $('.moreless-button').click(function() {
                if ($('.moreless-button').text() == "Read more") {
                  self.$refs.detail.style.maxHeight = 'none';
                  $(this).text("Read less")
                } else {
                  self.$refs.detail.style.maxHeight = '200px';
                  $(this).text("Read more")
                }
              });
            });

		},
    methods:{
      
    }
	}
</script>