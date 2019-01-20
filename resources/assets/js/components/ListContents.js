Vue.component('list-contents', {
  props: {
    initValue: {
      type: Array,
      default: () => ({}),
    }
  },
  data() {
    return {
      files: {},
    }
  },
  created() {
    this.showList(this.initValue)
  },
  methods: {
    showList(value) {
      //
    }
  }
})
