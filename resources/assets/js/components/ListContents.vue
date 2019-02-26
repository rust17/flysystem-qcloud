<template>
  <div class="panel">
    <div class="flex flex-wrap justify-center -mx-3 mb-3 mt-3">
      <div class="w-full md:w-1/6 px-3 ml-6">
        <div class="relative">
          <select class="block w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="selected">
            <option v-for="item in options" v-bind:value="item.value">{{ item.name }}</option>
          </select>
        </div>
      </div>
      <div class="w-full md:w-1/3 px-3">
        <div class="relative">
          <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border rounded py-2 mb-3 leading-tight pin-r focus:outline-none focus:bg-white" placeholder="enter your path" type="text" name="path" v-model="path">
          <div class="absolute pin-y pin-r pr-3 flex items-center cursor-pointer" @click="search()">
            <svg class="fill-current pointer-events-none text-grey-dark w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path></svg>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/6 px-3 ml-6">
        <div class="relative">
          <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="alertUpload()">upload file</button>
        </div>
      </div>
    </div>
    <div class="w-full">
      <table class="w-full max-w-full text-center border">
        <colgroup>
          <col>
          <col>
          <col>
          <col>
          <col>
        </colgroup>
        <tr>
          <th>ID</th>
          <th>文件名</th>
          <th>大小</th>
          <th>最后修改时间</th>
          <th>文件类型</th>
          <th>操作</th>
        </tr>
        <tr v-for="(file, key) in files">
          <td>{{ file.id }}</td>
          <td><a href="javascript:;" @click="alertRename(file.id)" class="no-underline text-blue">{{ file.filename }}</a></td>
          <td>{{ file.size }}</td>
          <td>{{ file.lastModified }}</td>
          <td>{{ file.extension }}</td>
          <td>
            <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" @click="alertCopy(file.id)">
              copy
            </button>
            <button class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 hover:border-transparent rounded" @click="alertDelete(file.id)">
              delete
            </button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ['route'],
  name: 'ListContents',
  data() {
    return {
      selected: 1,
      path: '',
      options: [
        {
          name: 'list contents',
          value: 1
        },
        {
          name: 'has file',
          value: 2
        }
      ],
      files: []
    }
  },
  watch: {
    selected(value) {
      if (value) {
        this.path = ''
      }
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    fetch(page = 1) {
      axios.get(`/${this.route}/list_contents?directory=/&page=` + page).then(({ data }) => {
        this.files = data.data
      })
    },
    search() {
      if (this.selected === 1) {
        axios.get(`/${this.route}/list_contents?directory=${this.path}&page=1`).then(({ data }) => {
          this.files = data.data
        })
      } else if (this.selected === 2) {
        axios.get(`/${this.route}/exists?filename=${this.path}`).then(({ data }) => {
          this.files = data.data
        })
      }
    },
    alertCopy(fileId) {
      swal({
        title: "Copy File？",
        content: {
          element: "input",
          attributes: {
            placeholder: 'Please type your new filename'
          }
        },
        showCancelButton: true,
        buttons: {
          cancel: true,
          confirm: true
        }
      })
        .then((inputValue) => {
          if (inputValue) {
            axios.post(`/${this.route}/files/${fileId}/copy`, {
              'newFilename': inputValue
            })
            .then(({ data }) => {
              this.files.push(data.data)
              swal({
                title: 'copy success!'
              })
            })
            .catch((error) => {
              swal({
                title: error.response.data.message
              })
            })
          }
        })
    },
    alertDelete(fileId) {
      swal({
        title: 'Delete File？',
        showCancelButton: true,
        buttons: {
          cancel: true,
          confirm: true
        }
      })
        .then(() => {
          axios.delete(`/${this.route}/files/${fileId}`)
            .then((response) => {
              if (response.status === 204) {
                swal({
                  title: 'Delete Success！'
                })
                  .then(() => {
                  for (let file of this.files) {
                    if (parseInt(file.id) === parseInt(fileId)) {
                      this.files.splice(this.files.indexOf(file), 1)
                      break
                    }
                  }
                })
              }
            })
            .catch((error) => {
              swal({
                title: error.response.data.message
              })
            })
        })
    },
    alertRename(fileId) {
      swal({
        title: 'Rename File？',
        content: {
          element: "input",
          attributes: {
            placeholder: "Please input new filename"
          }
        },
        showCancelButton: true,
        buttons: {
          cancel: true,
          confirm: true
        }
      })
       .then((inputValue) => {
        if (inputValue) {
          axios.patch(`/${this.route}/files/${fileId}/rename`, {
            'newFilename': inputValue
          })
            .then(({ data }) => {
              swal({
                title: 'Rename Success！'
              })
                .then(() => { this.updateFile(data.data) })
            })
            .catch((error) => {
              swal({
                title: error.response.data.message
              })
            })
          }
       })
    },
    updateFile(newFile) {
      for (let file of this.files) {
        if (parseInt(newFile.id) === parseInt(file.id)) {
          file.filename = newFile.filename
          file.size = newFile.size
          file.lastModified = newFile.lastModified
          file.extension = newFile.extension
          break
        }
      }
    },
    alertUpload() {
      this.$upload.setUrl(`${this.route}/files`)
      this.$upload.show()
    }
  }
}
</script>

<style scoped>
th, td { padding: 20px; border: 1px solid #dae1e7; }
input::-webkit-input-placeholder { padding-left: .75rem; }
</style>
