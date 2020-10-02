<template>
    <div class="container">
        <ul class="checkout-progress-bar">
            <li @click="step = 1" v-bind:class="{ 'active': step == 1 }">
                <span>Shipping</span>
            </li>
            <li @click="step = 2" v-bind:class="{ 'active': step == 2 }">
                <span>Review &amp; Payments</span>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Summary</h3>

                    <h4>
                        <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button" aria-expanded="false" aria-controls="order-cart-section">{{ totalQuantity }} products in Cart</a>
                    </h4>

                    <div class="collapse" id="order-cart-section">
                        <table class="table table-mini-cart">
                            <tbody>
                                
                                <tr v-for="cartEntry in cart" :key="cartEntry.id">
                                    <td class="product-col">
                                        <figure class="product-image-container">
                                            <a href="#" class="product-image">
                                                <img  :src="'https://res.cloudinary.com/pixel-penguin/image/upload/c_fill,g_north,h_600,w_600/v1/'+cartEntry.product.gallery[0].image_name+'.jpg'" alt="product">
                                            </a>
                                        </figure>
                                        <div>
                                            <h2 class="product-title">
                                                <a :href="'product/'+cartEntry.product.link_name">{{ cartEntry.name }}</a>
                                            </h2>

                                            <span class="product-qty">Qty: {{cartEntry.quantity}}</span>
                                        </div>
                                    </td>
                                    <td class="price-col">{{currency}}{{cartEntry.price * cartEntry.quantity}}</td>
                                </tr>

                                
                            </tbody>    
                        </table>
                    </div><!-- End #order-cart-section -->
                </div><!-- End .order-summary -->

                <div class="checkout-info-box">
                    <h3 class="step-title">Ship To:
                        <a @click="step = 1" href="#" title="Edit" class="step-title-edit"><span class="sr-only">Edit</span><i class="icon-pencil"></i></a>
                    </h3>

                    <address>
                        {{user.name}} <br>
                        {{user.postal_code}}<br>
                        <select disabled v-model="user.country_id">
                            <option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
                        </select>
                        <select disabled v-model="user.city_id">
                            <option v-for="city in cities" :key="city.id" :value="city.id">{{city.name}}</option>
                        </select><br>
                        {{user.street_address_1}}<br>
                        {{user.street_address_2}}<br>
                        {{user.contact_number}}
                    </address>
                </div><!-- End .checkout-info-box -->
                
                <div class="checkout-info-box">
                    <h3 class="step-title">Shipping Method: 
                        <a @click="step = 1" href="#" title="Edit" class="step-title-edit"><span class="sr-only">Edit</span><i class="icon-pencil"></i></a>
                    </h3>

                    <p v-if="shippingMethod != null">{{shippingMethod.name}} - <strong>{{currency}}{{shipping_price}}</strong></p>
                </div><!-- End .checkout-info-box -->
            </div><!-- End .col-lg-4 -->

            <div class="col-lg-8 order-lg-first">
                <div v-if="step == 1" class="checkout-payment">
                    
                    <ul class="checkout-steps">
                        <li>
                            <h2 class="step-title">Shipping Address</h2>
                            
                            <!--
                            <form action="#">
                                <div class="form-group required-field">
                                    <label>Email Address </label>
                                    <div class="form-control-tooltip">
                                        <input type="email" class="form-control" required>
                                        <span class="input-tooltip" data-toggle="tooltip" title="We'll send your order confirmation here." data-placement="right"><i class="icon-question-circle"></i></span>
                                    </div>
                                </div>

                                <div class="form-group required-field">
                                    <label>Password </label>
                                    <input type="password" class="form-control" required>
                                </div>
                                
                                <p>You already have an account with us. Sign in or continue as guest.</p>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary">LOGIN</button>
                                    <a href="forgot-password.html" class="forget-pass"> Forgot your password?</a>
                                </div>
                            </form>
                            -->
                            <form action="#">
                                <div class="form-group required-field">
                                    <label>Your  Name </label>
                                    <input v-model="user.name" type="text" class="form-control" required>
                                </div>

                                <!--
                                <div class="form-group">
                                    <label>Company </label>
                                    <input type="text" class="form-control">
                                </div>
                                -->

                                <div class="form-group required-field">
                                    <label>Street Address </label>
                                    <input v-model="user.street_address_1" type="text" class="form-control" required>
                                    <input v-model="user.street_address_2" type="text" class="form-control" required>
                                </div><!-- End .form-group -->

                                
                                <!--
                                <div class="form-group">
                                    <label>State/Province</label>
                                    <div class="select-custom">
                                        <select class="form-control">
                                            <option value="CA">California</option>
                                            <option value="TX">Texas</option>
                                        </select>
                                    </div>
                                </div>
                                -->

                                <div class="form-group required-field">
                                    <label>Zip/Postal Code </label>
                                    <input v-model="user.postal_code" type="text" class="form-control" required>
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label>Country</label>
                                    <div class="select-custom">
                                        <select @change="getAllCitiesByCountry" v-model="user.country_id" class="form-control">
                                            <option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .form-group -->

                                <div class="form-group" v-if="cities.length > 0">
                                    <label>City</label>
                                    <div class="select-custom">
                                        <select v-model="user.city_id" class="form-control">
                                            <option v-for="city in cities" :key="city.id" :value="city.id">{{city.name}}</option>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .form-group -->

                                <div class="form-group required-field">
                                    <label>Phone Number </label>
                                    <div class="form-control-tooltip">
                                        <input v-model="user.contact_number" type="tel" class="form-control" required>
                                        <span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right"><i class="icon-question-circle"></i></span>
                                    </div><!-- End .form-control-tooltip -->
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label>Shipping Method</label>
                                    <div class="select-custom">
                                        <select @change="getShippingInfo" v-model="shippingMethodId" class="form-control">
                                            <option v-for="shippingMethod in shippingMethods" :key="shippingMethod.id" :value="shippingMethod.id">{{shippingMethod.name}}</option>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <div @click="step = 2" class="btn btn-primary">Next</div>
                                </div><!-- End .form-group -->

                            </form>
                        </li>
                        <!--
                        <li>
                            <div class="checkout-step-shipping">
                                <h2 class="step-title">Shipping Methods</h2>

                                <table class="table table-step-shipping">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="shipping-method" value="flat"></td>
                                            <td><strong>$20.00</strong></td>
                                            <td>Fixed</td>
                                            <td>Flat Rate</td>
                                        </tr>

                                        <tr>
                                            <td><input type="radio" name="shipping-method" value="best"></td>
                                            <td><strong>$15.00</strong></td>
                                            <td>Table Rate</td>
                                            <td>Best Way</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        -->
                    </ul>

                </div><!-- End .checkout-payment -->
                <div v-if="step == 2" class="checkout-payment">
                    <h2 class="step-title">Payment Method:</h2>

                    <h4>Check / Money order</h4>

                    

                    <div class="clearfix">
                        <a @click="placeOrder" href="#" class="btn btn-primary float-right">Place Order</a>
                    </div><!-- End .clearfix -->
                </div><!-- End .checkout-payment -->

                <!--
                <div class="checkout-discount">
                    <h4>
                        <a data-toggle="collapse" href="#checkout-discount-section" class="collapsed" role="button" aria-expanded="false" aria-controls="checkout-discount-section">Apply Discount Code</a>
                    </h4>

                    <div class="collapse" id="checkout-discount-section">
                        <form action="#">
                                <input type="text" class="form-control form-control-sm" placeholder="Enter discount code"  required>
                                <button class="btn btn-sm btn-outline-secondary" type="submit">Apply Discount</button>
                        </form>
                    </div>
                </div>
                -->
            </div><!-- End .col-lg-8 -->
        </div><!-- End .row -->
    </div>		
</template>

<script>
    
    export default {
        name: 'Blogs',
        data(){
            return{
                loading: null,
                step: 1,
                
                cloudinaryCloudName:null,
                currency:null,

                user: [],
                countries: [],
                cities:[],

                cart:[],
                subtotal:0,
                totalQuantity: 0,

                shipping_price: null,
                shipping_deliver: false,
                shippingMethods: [],
                shippingMethod: [],
                shippingMethodId:0
                
                
            }
        },
        mounted() {
            const self = this;

            self.cloudinaryCloudName = process.env.MIX_CLOUDINARY_CLOUD_NAME;
            self.currency = process.env.MIX_CURRENCY;

            self.getUserDetail();
            self.getCountries();
            self.getCart();
        },
        methods:{
            
            getShippingInfo(){
                const self = this;

                //self.loader(true);

                axios.get('/json/shipping/getinfo/'+self.user.city_id+'/'+self.user.country_id+'/'+self.shippingMethodId)
                .then(response => {
                    //console.log(response);

                    var data = response.data;
                    
                    self.shipping_price = data.price;
                    self.shipping_deliver = data.deliver;
                    self.shippingMethods = data.shippingMethods;
                    self.shippingMethod = data.shippingMethod;

                    self.loader(false);
                    //console.log(data);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
            },
            getUserDetail(){
                const self = this;

                //self.loader(true);

                axios.get('/json/user/detail/currentuser')
                .then(response => {
                    //console.log(response);

                    var data = response.data;
                    
                    self.user = data.obj;

                    if(self.user.country_id != 0){
                        self.getAllCitiesByCountry();
                    }

                    self.getShippingInfo();

                    self.loader(false);
                    //console.log(data);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
            },
            getCountries(){
                const self = this;

                //self.loader(true);

                axios.get('/json/countries/getall')
                .then(response => {
                    //console.log(response);

                    var data = response.data;
                    
                    self.countries = data.obj;

                    self.loader(false);
                    //console.log(data);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
            },
            getAllCitiesByCountry(){
                const self = this;

                //self.loader(true);

                axios.get('/json/cities/getbycountry/'+self.user.country_id)
                .then(response => {
                    //console.log(response);

                    var data = response.data;
                    
                    self.cities = data.obj;

                    self.loader(false);
                    //console.log(data);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
            },

            updateCart(){
                const self = this;
                
                Hub.$refs.cartSystem.updateCart(self.cart);
                
                setTimeout(function(){
                    self.getCart();
                },1000)
                //var result = await Hub.$refs.cartSystem.updateCart(self.cart);
                
            },
            getCart(){
                const self = this;

                //self.loader(true);

                axios.get('/cart/get')
                .then(response => {
                    //console.log(response);

                    var data = response.data;
                    
                    self.cart = data.obj;

                    self.subtotal = data.subtotal;
                    self.totalQuantity = data.totalQuantity;

                    self.loader(false);
                    //console.log(data);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
            },
            placeOrder(itemId){
                
                
                const self = this;

                //self.loader(true);

                axios.post('/json/shipping/placeorder',{
                    user: self.user,
                    sale_shipping_method_id: self.shippingMethodId,
                })
                .then(response => {
                    //console.log(response);

                    var data = response.data;                    
                   
                    var sale = data.data;

                    self.loader(false);

                    window.location = '/thankyou/'+sale.reference_code;
                    //console.log(data);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
			}, 
                    
            addCommas(nStr){
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            },
            loader(value){
                const self = this;

                self.loading = value;
            }
            
        }

    }

</script>
<style v-if="show">
.hooper{height: auto;}
</style>