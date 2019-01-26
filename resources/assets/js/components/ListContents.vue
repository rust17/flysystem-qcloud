<template>
  <div class="list-contents absolute pin overflow-auto pt-16 pb-4">
    <div class="flex flex-wrap -mx-3 mb-3 mt-3">
      <div class="w-full md:w-1/6 px-3 ml-6">
        <div class="relative">
          <select class="block w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option v-for="item in options" value="item.value">{{ item.name }}</option>
          </select>
        </div>
      </div>
      <div class="w-full md:w-1/3 px-3">
        <div class="relative">
          <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border rounded py-2 mb-3 leading-tight pin-r focus:outline-none focus:bg-white" placeholder="enter your path" type="text" name="path" v-model="path" v-on:change="handleFiles()">
        </div>
      </div>
    </div>
    <div class="">
      <table>
        <tr>
          <th>ID</th>
          <th>文件名</th>
          <th>大小</th>
          <th>最后修改时间</th>
          <th>文件类型</th>
        </tr>
        <tr v-for="(file, key) in files">
          <td>{{ key }}</td>
          <td>{{ file.filename }}</td>
          <td>{{ file.size }}</td>
          <td>{{ file.lastModified }}</td>
          <td>{{ file.extension }}</td>
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
      path: '',
      options: [
        {
          name: 'path',
          value: 1
        },
        {
          name: 'filename',
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
      axios.get(`/${this.route}/${this.basicUrl}/${this.path}` + page).then(({data}) => {})
    }
  }
}
</script>

