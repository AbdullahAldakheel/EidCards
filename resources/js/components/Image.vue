<template>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row d-flex justify-content-center">
                        <div class="card" >
                            <img class="card-img-top" :src="'i'+image" alt="Card image cap""
                            style="cursor: pointer;" >
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="downloadImage">تحميل</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Image",
        data(){
           return{
               image: '',
               name: ''
           }
        },
        mounted() {
            this.$root.$on('image', e =>{
                this.image = e.img
                this.name = e.name
                $('#exampleModal').modal();
            })
        },
        methods:{
            async downloadImage() {
                const image = await fetch(this.image)
                const imageBlog = await image.blob()
                const imageURL = URL.createObjectURL(imageBlog)
                const link = document.createElement('a')
                link.href = imageURL
                link.download =   "بطاقة_"  + this.name
                document.body.appendChild(link)
                link.click()
                document.body.removeChild(link)
            }
        }
    }
</script>

<style scoped>

</style>
