<template>
    <div>
        <button type="button" class="btn btn-block btn-primary" @click="clickUpload">Upload</button>

        <input type="file" :id="data.name" :name="data.name" @change="uploadFieldChange" :data-vv-as="data.label" v-validate="validate" multiple style="display: none" ref="files"/>

        <div class="dropzone-previews mt-3" id="file-previews">
            <div class="card mt-1 mb-0 shadow-none border border-light dz-processing dz-success dz-complete" v-for="(attachment, index) in attachments">
                <div class="p-2">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img data-dz-thumbnail="" class="avatar-sm rounded bg-light" :alt="attachment.name" :src="createImage(attachment)" v-if="typeAttachment(attachment)">

                            <i class="avatar-sm rounded fa-3x text-center" :class="iconFile(attachment)" v-else></i>
                        </div>
                        <div class="col pl-0">
                            <a class="text-muted font-weight-bold">{{ attachment.name }}</a>
                            <p class="mb-0" data-dz-size=""><strong>{{ Number((attachment.size / 1024 / 1024).toFixed(1)) }}</strong> MB</p>
                        </div>
                        <div class="col-auto">
                            <!-- Button -->
                            <button type="button" class="btn btn-link btn-lg text-muted" @click="removeAttachment(attachment)">
                                <i class="dripicons-cross"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "upload-input",
        inject: ['$validator'],
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
            }
        },
        data() {
            return {
                attachments: [],
                image: ''
            }
        },
        watch: {
            attachments(value) {
                this.data.value = value
            }
        },
        computed: {
            validate() {
                if (typeof this.data.validate === "string") {
                    return this.data.validate
                } else if (this.data.validate === undefined) {
                    return ''
                } else {
                    return 'required'
                }
            }
        },
        methods: {
            clickUpload() {
                this.$refs.files.click()
            },
            removeAttachment(attachment) {
                this.attachments.splice(this.attachments.indexOf(attachment), 1);
            },
            uploadFieldChange(e) {
                let files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;

                for( let i = 0; i < files.length; i++ ){
                    this.attachments.push(files[i]);
                }
            },
            createImage(file) {
                let reader = new FileReader(),
                    me = this

                reader.onload = (e) => {
                    me.image = e.target.result
                }

                reader.readAsDataURL(file)

                return this.image
            },
            iconFile(file) {
                return file.type === "application/pdf" ? "fas fa-file-pdf" : "fas fa-file-alt"
            },
            typeAttachment(file) {
                const allowedFileTypes = ["image/png", "image/jpeg", "image/gif"];

                return allowedFileTypes.indexOf(file.type) > -1
            }
        },
        mounted () {
            this.$emit('uploads')
        }
    }
</script>
