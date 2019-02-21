<template>
  <div v-show="show">
    <div class="container w-2/5 h-3/4 fixed pin z-1000 overflow-auto block mx-auto my-auto shadow-lg bg-white">
      <div class="px-6 py-4">
        <strong class="text-2xl">upload</strong>
        <button @click="close" type="button" class="close float-right"><span>x</span></button>
      </div>

      <div class="px-6 py-4 text-center">
        <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button" @click="alertUpload()">upload file</button>
        <div class="filezone mt-5">
          <input class="hidden" type="file" id="file" ref="file" multiple @change="handleFiles()">
          <div class="px-6 py-4 flex" v-if="file.length > 0">
            <div class="flex-1 text-left"><span>{{ file[0].name }}</span></div>
            <div class="flex-1 text-center"><span>{{ file[0].size }}</span></div>
            <div class="flex-1 text-right"><a href="javascript:;" class="text-blue hover:text-red" @click="removeFile()">remove</a></div>
          </div>
          <p v-else>
            Or drop your files here
          </p>
        </div>
      </div>

      <div class="px-6 py-4 text-right">
        <button class="bg-blue text-white font-bold py-2 px-4 rounded" type="button" @click="submitFile()" v-show="file.length > 0">Submit</button>
      </div>
    </div>
    <div class="mask fixed pin-l pin-t z-999 w-full h-full opacity-50 block bg-black"></div>
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
      file: {},
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

      console.log(this.file)

      // this.getFilePreview();
    },
    getFilePreview() {
      this.$nextTick(() => {
        this.filename = this.file.name
        this.filesize = this.file.size
      })
    },
    removeFile() {
      this.file = null
      // this.getFilePreview()
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

<style scoped>
.filezone {
  outline: 2px dashed grey;
  outline-offset: -10px;
  color: dimgray;
  padding: 10px 10px;
  min-height: 270px;
  position: relative;
  cursor: pointer;
}

.filezone p {
  font-size: 1.2em;
  text-align: center;
  padding: 50px 50px 50px 50px;
}
</style>
