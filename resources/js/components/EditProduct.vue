<template>
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" v-model="product.title" placeholder="Product Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Product SKU</label>
                            <input type="text" v-model="product.sku" placeholder="Product SKU" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea v-model="product.description" id="" cols="30" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                    </div>
                    <div class="card-body border">
                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow mb-4">



                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>Variant</td>
                                    <td>Price</td>
                                    <td>Stock</td>
                                </tr>
                                </thead>
                                <tbody>
<!--                                {{this.variants[5]}}-->
                                <tr v-for="(item,index) in product_variant_prices">
                                    <td>

                                        {{variants[item.product_variant_one]}}/{{variants[item.product_variant_two]}}/{{variants[item.product_variant_three]}}
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" v-model="item.price">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="item.stock">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button @click="updateProduct" type="submit" class="btn btn-lg btn-primary">Update</button>
        <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
    </section>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import InputTag from 'vue-input-tag'

export default {
    components: {
        vueDropzone: vue2Dropzone,
        InputTag
    },
    props: {
        product: {},
        product_variants: {},
        product_variant_prices : {}
    },
    data() {
        return {

            product : {
                title : '',
                sku : '',
                description : ''

            },
            product_variant_prices : {},
            variants :[]


        }
    },
    methods: {

        updateProduct() {
            console.log('Update');
            // console.log(this.product);
            //console.log(this.product_variant_prices);
            let product = {
                id : this.product.id,
                title: this.product.title,
                sku: this.product.sku,
                description: this.product.description,
                //product_image: this.images,
                product_variants: this.product_variants,
                product_variant_prices: this.product_variant_prices

            }
            console.log(product);


            axios.post('/update', product).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            })

            //console.log(product);
        }



    },
    mounted() {

        //console.log(this.product_variants);
        //var result = Object.keys(this.product_variants).map((key) => [Number(key), this.product_variants[key]]);



        var varia = []
        for (let i = 0; i < this.product_variants.length; i++) {
            console.log(this.product_variants[i].variant);
            varia[this.product_variants[i].id] = this.product_variants[i].variant
        }

        this.variants = varia

        console.log(this.variants)

        console.log('Component mounted.')
    }
}
</script>
