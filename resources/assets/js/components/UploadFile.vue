<template>
  <div v-show="show">
    <div class="container w-2/5 h-3/4 fixed pin z-1000 overflow-auto block mx-auto my-auto shadow-lg bg-white">
      <div class="px-6 py-4">
        <strong class="text-2xl">upload</strong>
        <button @click="close" type="button" class="close float-right"><span>x</span></button>
      </div>

      <div class="px-6 py-4 text-center">
        <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button" @click="alertUpload()">upload file</button>
        <div class="filezone mt-5 align-middle">
          <input class="hidden" type="file" id="file" ref="file" multiple @change="handleFiles()">
          <p>
            Or drop your files here
          </p>
        </div>
      </div>

      <!-- <div class="px-6 py-4 inline-flex">
        <div class="flex-1 text-center">{{ filename }}</div>
        <div class="flex-1 text-center">{{ filesize }}</div>
        <div class="flex-1 text-center"><a href="javascript:;" class="text-blue hover:text-red" @click="removeFile()">remove</a></div>
      </div> -->

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

<style scoped>
.filezone {
  outline: 2px dashed grey;
  outline-offset: -10px;
  background: #bcdefa;
  color: dimgray;
  padding: 10px 10px;
  min-height: 270px;
  position: relative;
  cursor: pointer;
}
.filezone:hover {
  background: #6cb2eb;
}

.filezone p {
  font-size: 1.2em;
  text-align: center;
  padding: 50px 50px 50px 50px;
}
</style>
