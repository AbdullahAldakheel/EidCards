<template>
    <div id="add" class="bg-add text-center ">
        <h2>إضافة بطاقة جديدة</h2>
        <p class="lead">c</p>

        <div class="">
            <div class="form-row row justify-content-center">
                <div class="form-group col-md-3 ">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Password</label>
                    <select class="form-control" id="inputPassword4">
                        <option>Default select</option>
                        <option>Default select</option>
                        <option>Default select</option>
                    </select>
                </div>
            </div>
            <div class="form-row row justify-content-center">
            <div class="form-group  col-md-6 row ">
                <label for="exampleFormControlTextarea1">Example textarea</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            </div>



        </div>

        <div v-show="image">
            <img id="imagePreview" class="image-display"/>
            <div class="drag-name" id="drag-name">
                (مكان الأسم)
            </div>
        </div>

        <!-- Upload  -->
        <div v-if="!image" id="file-upload-form" class="uploader form-group  col-md-6 row ">
            <input id="file-upload" type="file" name="fileUpload" accept="image/*"/>

            <label for="file-upload" id="file-drag">
                <div id="start">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    <div>أرفع صورة أو اسحب هنا</div>
                    <span id="file-upload-btn" class="btn btn-primary">أرفع</span>
                </div>
                <!--                <div id="response" >-->
                <!--                    <div id="messages"></div>-->
                <!--                    <progress class="progress" id="file-progress" value="2">-->
                <!--                        <span>4</span>%-->
                <!--                    </progress>-->
                <!--                </div>-->
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
</template>

<script>
    var mousePosition;
    var offset = [0, 0];
    var div;
    var isDown = false;
    export default {
        name: "Add",
        data() {
            return {
                image: null
            }
        },
        mounted() {
            let that = this;
            $("#file-upload").change(function () {
                console.log(1);
                that.readURL(this, false)
            });
            let fileDrag = document.getElementById('file-drag');

            fileDrag.addEventListener('dragover', this.fileDragHover, false);
            fileDrag.addEventListener('dragleave', this.fileDragHover, false);
            fileDrag.addEventListener('drop', this.readURL, false);

            let div = document.getElementById('drag-name');


            div.addEventListener('mousedown', function (e) {
                isDown = true;
                offset = [
                    div.offsetLeft - e.clientX,
                    div.offsetTop - e.clientY
                ];
            }, true);

            document.addEventListener('mouseup', function () {
                isDown = false;
            }, true);

            document.addEventListener('mousemove', function (event) {
                event.preventDefault();
                if (isDown) {
                    mousePosition = {

                        x: event.clientX,
                        y: event.clientY

                    };
                    div.style.left = (mousePosition.x + offset[0]) + 'px';
                    div.style.top = (mousePosition.y + offset[1]) + 'px';
                }
            }, true);
        },
        methods: {
            fileDragHover(e) {
                var fileDrag = document.getElementById('file-drag');

                e.stopPropagation();
                e.preventDefault();

                fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
            },
            addImage() {

            }, beforeRemove() {

            }, editImage() {

            },
            readDrag(e) {
                console.log(e.target, e);
                var files = e.target.files || e.dataTransfer.files;
                console.log(files);
            },
            readURL(input, isDrag = true) {
                if (isDrag)
                    input = {files: input.target.files || input.dataTransfer.files};
                let that = this;
                console.log(input);
                if (input.files && input.files[0]) {
                    console.log('Found File');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        that.image = [input.files[0]];

                        $('#imagePreview').attr('src', e.target.result);
                        // $('#imagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
    }
</script>

<style scoped type="scss">


</style>
