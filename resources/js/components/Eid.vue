<template>
    <div class="text-center">
        <image-component></image-component>
        <h3 class="mt-2">مرات التحميل {{times}}</h3>
        <h1 class="mt-5">كل عام وانتم بخير</h1>
        <p class="lead">بطاقة معايدة</p>
        <ul class="list-unstyled">
            <div class="form-row d-flex justify-content-center">
                <div class=" mb-2 mb-md-0">
                    <input class="form-control form-control-lg" type="email"
                           v-model="data.name"
                                                  placeholder="أسمك ..">
                </div>


            </div>
            <small v-if="errors['name']" style="color: red">اكتب اسمك</small>
            <h2 class="mt-5">اختر صورة</h2>
            <small v-if="errors['image']" style="color: red">لازم تختار صورة</small>
        </ul>
        <div>
            <ul class="list-group flex-md-row justify-content-center">
                <li class="list-group-item" v-for="(image, index) in images"><img  class="card-img-top"  :src="'/img/'+image" @click="setImage(image)" style="cursor: pointer; width: 200px; height: 200px" :class="data.image == image ? 'selected-img' : ''"></li>
            </ul>

        </div>


        <div class="form-row d-flex justify-content-center mt-3">
            <div class="ml-2">
                <button class="btn btn-block btn-lg btn-success" @click="send" :disabled="loading">
                    <span class="spinner-border" role="status" v-if="loading">
                    </span>
                    <span v-else>
                        كتابة
                    </span>
                    </button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Eid",
        props: ['times'],
        data() {
            return {
                images: ['eid1.png', 'eid2.png', 'eid3.png', 'eid4.png'],
                data:{
                    name: '',
                    image: ''
                },
                loading: false,
                errors: {}
            }
        },
        methods:{
            setImage(index){
                this.data.image = index
            },
            send(){
                this.loading = true;
                try {
                    axios.post('/api/create', this.data).then(e =>{
                        this.$root.$emit('image', {img: e.data, name: this.data.name});
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                    }).finally(e =>{
                        this.loading = false
                    })
                }catch (e) {
                    this.loading = false
                }

            }
        }
    }
</script>

<style scoped>
.selected-img{
    border-color: grey;
    border-radius: 10px;
    border-style: solid;
}
</style>
