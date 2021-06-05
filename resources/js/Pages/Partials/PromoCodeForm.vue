<template>
    <div>
        <div class="w-full pb-2">
            <input type="text" class="form-input w-full" v-model="promoCode" placeholder="Promo code">
        </div>
        <div class="w-full pb-2">
            <input type="number" class="form-input w-full" min="0" max="100" v-model="discount" placeholder="Discount amount">
        </div>
        <div class="w-full pb-2">
            <select name="discount type" v-model="discountType" id="discount-type" class="w-full">
                <option value="dollars">Dollars</option>
                <option value="percent">Percent</option>
            </select>
        </div>
        <div class="w-full pb-2">
            <select name="discount status" v-model="status" id="discount-status" class="w-full">
                <option :value="0">Not Active</option>
                <option :value="1">Active</option>
            </select>
        </div>
        <div v-if="promoCode && promoCode != '' && discount > 0" class="w-full">
            <button class="bg-primary p-2 bold text-white w-full" @click.prevent="storePromoCode()">
                Submit
            </button>
        </div>        
    </div>
</template>

<script>

    export default {
        components: {
   
        },
        props: ['concertId'],
        mounted() {
            
        },
        data() {
            return {
                promoCode: null,
                discount: 0,
                discountType:'dollars',
                status: 0
            }
        },
        methods: {
            storePromoCode: function() {
                axios.post('/web-api/post/promo-code', {
                    concert_id: this.concertId,
                    code: this.promoCode,
                    discount: this.discount,
                    discount_type: this.discountType,
                    status: this.status,
                }).then((response) => {
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                });
            }
        }
    }
</script>
