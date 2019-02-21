<template>
  <div v-show="show" class="fixed pin z-1000 overflow-auto block">
    <button @click="close" type="button" class="close"><span>x</span></button>
    <div class="container mx-auto shadow-lg">
      <div class="px-6 py-4">
        <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button" @click="alertUpload()">upload file</button>
        <input class="hidden" type="file" id="file" ref="file" multiple @change="handleFiles()">
        <p>
          Drop your files here
        </p>
      </div>

      <div class="px-6 py-4 inline-flex">
        <div class="flex-1 text-center">{{ filename }}</div>
        <div class="flex-1 text-center">{{ filesize }}</div>
        <div class="flex-1 text-center"><a href="javascript:;" class="text-blue hover:text-red" @click="removeFile()">remove</a></div>
      </div>

      <button class="bg-blue text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed" type="button" @click="submitFile()" v-show="file.length > 0">Submit</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UploadFile',
  props: {
    show: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      file: [],
      filename: '',
      filesize: '',
      route: ''
    }
  },
  methods: {
    close() {
      this.$emit('update:show', false)
    },
    alertUpload() {
      document.getElementById('file').click();
    },
    handleFiles() {
      let uploadFile = this.$refs.file.files;

      this.file = uploadFile

      this.getFilePreview();
    },
    getFilePreview() {
      this.$nextTick(() => {
        this.filename = this.file.filename
        this.filesize = this.file.filesize
      })
    },
    removeFile() {
      this.file = ''
      this.getFilePreview()
    },
    submitFile() {
      if (this.file) {
        let formData = new FormData()
        formData.append('file', this.file)

        axios.post(`${this.route}/files`,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        ).then(() => {
          swal({
            title: "上传成功"
          })
        })
      } else {
        swal({
          title: "请先上传文件",
          type: "error",
          showCancelButton: true,
          closeOnConfirm: true
        })
      }
    }
  }
}
</script>
