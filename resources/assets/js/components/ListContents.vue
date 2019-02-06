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
          <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border rounded py-2 mb-3 leading-tight pin-r focus:outline-none focus:bg-white" placeholder="enter your path" type="text" name="path" v-model="path" v-on:change="handleFiles()">
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
          <td>{{ key }}</td>
          <td>{{ file.filename }}</td>
          <td>{{ file.size }}</td>
          <td>{{ file.lastModified }}</td>
          <td>{{ file.extension }}</td>
          <td>
            <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" @click="alertCopy()">
              copy
            </button>
            <button class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 hover:border-transparent rounded">
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
      files: [
        {
          filename: 'example',
          size: '358939',
          lastModified: '2019-01-06T08:58:44.000Z',
          extension: 'jpg'
        },
        {
          filename: 'example',
          size: '358939',
          lastModified: '2019-01-06T08:58:44.000Z',
          extension: 'jpg'
        },
        {
          filename: 'example',
          size: '358939',
          lastModified: '2019-01-06T08:58:44.000Z',
          extension: 'jpg'
        },
        {
          filename: 'example',
          size: '358939',
          lastModified: '2019-01-06T08:58:44.000Z',
          extension: 'jpg'
        },
      ]
    }
  },
  watch: {
    selected(value) {
      if (value) {
        this.path = ''
      }
    }
  },
  // created() {
  //   this.fetch()
  // },
  beforeCreate() {
    this.basicUrl = 'list_contents';
  },
  methods: {
    fetch(page = 1) {
      axios.get(`/${this.route}/${this.basicUrl}/${this.path}` + page).then(({data}) => {})
    },
    handleFiles() {
      return ;
      // axios.get(`/${this.route}/${this.basicUrl}/${this.path}` + page).then(({data}) => {})
    },
    alertCopy() {
      swal({
        title: "确定复制该文件？",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: true
      })
        .then(() => {
          console.log('click yes');
        });
    }
  }
}
</script>

<style scoped>
th, td { padding: 20px; border: 1px solid #dae1e7; }
</style>
