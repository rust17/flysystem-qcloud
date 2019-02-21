<template>
  <div v-show="show">
    <div class="container w-2/5 h-3/4 fixed pin z-1000 overflow-auto block mx-auto my-auto shadow-lg bg-white">
      <div class="px-6 py-4">
        <strong class="text-2xl">upload</strong>
        <button @click="close" type="button" class="close float-right"><span><svg class="fill-current h-6 w-6 text-red" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg></span></button>
      </div>

      <div class="px-6 py-4 text-center">
        <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button" @click="alertUpload()">upload file</button>
        <div class="filezone mt-5">
          <input class="hidden" type="file" id="files" ref="file" multiple @change="handleFiles()">
          <div class="px-6 py-4 flex" v-if="files.length > 0" v-for="(file, index) in files">
            <div class="flex-1 text-left"><span>{{ file.name }}</span></div>
            <div class="flex-1 text-center"><span>{{ file.size }}</span></div>
            <div class="flex-1 text-right"><a href="javascript:;" class="text-blue hover:text-red" @click="removeFile(index)">remove</a></div>
          </div>
          <p v-else>
            Or drop your files here
          </p>
        </div>
      </div>

      <div class="px-6 py-4 absolute pin-r pin-b">
        <button class="bg-blue text-white font-bold py-2 px-4 rounded" type="button"  v-show="files.length > 0">Submit</button>
      </div>
    </div>
    <div class="mask fixed pin-l pin-t z-999 w-full h-full opacity-50 block bg-black" @click="close"></div>
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
      files: [],
      route: ''
    }
  },
  methods: {
    close() {
      this.$emit('update:show', false)
    },
    alertUpload() {
      document.getElementById('files').click();
    },
    handleFiles() {
      let uploadFiles = this.$refs.file.files;

      this.files = Object.entries(uploadFiles)

      console.log(this.files)

      this.getFilePreview();
    },
    getFilePreview() {
      this.$nextTick(() => {
        this.filename = this.file.name
        this.filesize = this.file.size
      })
    },
    removeFile(key) {
      this.files.splice(key, 1)
      // this.getFilePreview()
    },
    submitFile() {
      if (this.files) {
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

<style scoped>
.filezone {
  outline: 2px dashed grey;
  outline-offset: -10px;
  color: dimgray;
  padding: 10px 10px;
  min-height: 200px;
  position: relative;
  cursor: pointer;
}

.filezone p {
  font-size: 1.2em;
  text-align: center;
  padding: 50px 50px 50px 50px;
}
</style>
